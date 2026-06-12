<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        /* ── Jumlah Kriteria ── */
        $jumlahKriteria = 0;
        try {
            $jumlahKriteria = \App\Models\Kriteria::count();
        } catch (\Exception $e) {}

        /* ── Jumlah Siswa ── */
        $jumlahSiswa = 0;
        try {
            $jumlahSiswa = \App\Models\Siswa::count();
        } catch (\Exception $e) {}

        /* ── Data Siswa per Kelas (Bar Chart) ── */
        $dataKelas = [];
        try {
            $dataKelas = \App\Models\Siswa::selectRaw('kelas, COUNT(*) as total')
                ->groupBy('kelas')
                ->orderBy('kelas')
                ->pluck('total', 'kelas')
                ->toArray();
        } catch (\Exception $e) {}

        /* ── Status Input Nilai (Donut Chart) ── */
        $jumlahSudahInput = 0;
        $jumlahBelumInput = 0;
        try {
            $semuaSiswa       = \App\Models\Siswa::withCount('nilaiSiswas')->get();
            $jumlahSudahInput = $semuaSiswa->filter(fn($s) => $s->nilai_siswas_count > 0)->count();
            $jumlahBelumInput = $semuaSiswa->filter(fn($s) => $s->nilai_siswas_count === 0)->count();
        } catch (\Exception $e) {}

        /* ── Konsistensi AHP ── */
        $konsistensiAHP = '-';
        try {
            // matrix_json hanya ada di record pertama (index=0)
            $ahpRecord = \App\Models\Ahp::whereNotNull('matrix_json')->first();

            if ($ahpRecord && $ahpRecord->matrix_json) {
                // Eloquent mungkin sudah decode jadi array (tergantung $casts)
                $matrix = is_array($ahpRecord->matrix_json)
                    ? $ahpRecord->matrix_json
                    : json_decode($ahpRecord->matrix_json, true);

                $n = \App\Models\Kriteria::count();

                if (is_array($matrix) && $n >= 3) {
                    $konsistensiAHP = number_format($this->hitungCR($matrix, $n), 4);
                }
            }
        } catch (\Exception $e) {}

        /* ── Bobot Kriteria AHP (Progress Bar) ──────────────────────────
         * FIX: Struktur DB dari tinker menunjukkan bobot ada langsung di
         * tabel ahp (kolom: kriteria_id, bobot). Kita JOIN ke kriteria
         * untuk mendapatkan kode & nama.
         * Tidak pakai relasi $k->ahp karena mungkin tidak terdefinisi.
         * ─────────────────────────────────────────────────────────────── */
        $bobotKriteria = collect();
        try {
            // Ambil semua ahp yang punya bobot, join nama dari kriteria
            $bobotKriteria = \App\Models\Ahp::with('kriteria')
                ->where('bobot', '>', 0)
                ->get()
                ->filter(fn($a) => $a->kriteria !== null)
                ->sortBy(fn($a) => $a->kriteria->urutan ?? 999)
                ->map(fn($a) => (object)[
                    'kode'  => $a->kriteria->kode  ?? '-',
                    'nama'  => $a->kriteria->nama  ?? '-',
                    'bobot' => (float) $a->bobot,
                ])
                ->values();
        } catch (\Exception $e) {}

        /* ── Top Siswa SMART (Tabel Ranking) ────────────────────────────
         * FIX: SmartController menyimpan hasil di key 'tabel_skor' bukan
         * 'hasil'. Field yang dipakai: nama, kelas, total_skor.
         * ─────────────────────────────────────────────────────────────── */
        $topSiswa      = [];
        $jumlahTerbaik = 0;
        try {
            $riwayatTerbaru = \App\Models\Riwayat::where('jenis', 'smart')
                ->whereNotNull('data_json')
                ->latest()
                ->first();

            if ($riwayatTerbaru && $riwayatTerbaru->data_json) {
                // Eloquent mungkin sudah decode jadi array
                $dataJson = is_array($riwayatTerbaru->data_json)
                    ? $riwayatTerbaru->data_json
                    : json_decode($riwayatTerbaru->data_json, true);

                // FIX: key yang benar adalah 'tabel_skor', bukan 'hasil'
                if (isset($dataJson['tabel_skor']) && is_array($dataJson['tabel_skor'])) {
                    $jumlahTerbaik = count($dataJson['tabel_skor']);

                    // Normalisasi field agar blade bisa pakai 'siswa_nama' & 'skor_akhir'
                    $topSiswa = array_slice(
                        array_map(fn($row) => [
                            'siswa_nama' => $row['nama']       ?? '-',
                            'kelas'      => $row['kelas']      ?? '-',
                            'skor_akhir' => $row['total_skor'] ?? 0,
                        ], $dataJson['tabel_skor']),
                        0, 7
                    );
                }
            }
        } catch (\Exception $e) {}

        /* ── Periode Aktif ── */
        $periodeAktif = null;
        try {
            $periodeAktif = \App\Models\Periode::where('status', 'aktif')->first();
        } catch (\Exception $e) {}

        /* ── Kirim ke View ── */
        return view('dashboard', compact(
            'jumlahKriteria',
            'jumlahSiswa',
            'jumlahTerbaik',
            'konsistensiAHP',
            'dataKelas',
            'jumlahSudahInput',
            'jumlahBelumInput',
            'bobotKriteria',
            'topSiswa',
            'periodeAktif',
        ));
    }

    /* ── Helper hitung CR ── */
    private function hitungCR(array $matrix, int $n): float
    {
        $ri = [
            1=>0.00, 2=>0.00, 3=>0.58, 4=>0.90,  5=>1.12,
            6=>1.24, 7=>1.32, 8=>1.41, 9=>1.45, 10=>1.49,
        ];

        $colSum = array_fill(0, $n, 0.0);
        for ($j = 0; $j < $n; $j++)
            for ($i = 0; $i < $n; $i++)
                $colSum[$j] += ($matrix[$i][$j] ?? 0);

        $bobot = [];
        for ($i = 0; $i < $n; $i++) {
            $rowSum = 0;
            for ($j = 0; $j < $n; $j++)
                $rowSum += $colSum[$j] > 0 ? ($matrix[$i][$j] ?? 0) / $colSum[$j] : 0;
            $bobot[$i] = $rowSum / $n;
        }

        $lambdaMax = 0.0;
        for ($i = 0; $i < $n; $i++) {
            $aw = 0;
            for ($j = 0; $j < $n; $j++)
                $aw += ($matrix[$i][$j] ?? 0) * $bobot[$j];
            if ($bobot[$i] > 0) $lambdaMax += $aw / $bobot[$i];
        }
        $lambdaMax /= $n;

        $ci    = ($lambdaMax - $n) / max($n - 1, 1);
        $riVal = $ri[$n] ?? 1.49;
        return $riVal > 0 ? $ci / $riVal : 0.0;
    }
}