<?php

namespace App\Http\Controllers;

use App\Models\Ahp;
use App\Models\Kriteria;
use App\Models\NilaiSiswa;
use App\Models\Periode;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmartController extends Controller
{
    // =========================================================
    //  INDEX — tampilkan halaman + tabel seleksi siswa
    //  Perhitungan hanya ditampilkan jika ada riwayat hari ini
    //  atau jika request datang dari POST (setelah hitung)
    // =========================================================
    public function index(Request $request)
    {
        // ---------------------------
        // PERIODE
        // ---------------------------
        $periodes     = Periode::orderByDesc('created_at')->get();
        $periodeAktif = Periode::where('status', 'aktif')->first();

        $periodeId = $request->get('periode_id', optional($periodeAktif)->id);

        $periodeSeleksi = $periodes->firstWhere('id', $periodeId);

        // ---------------------------
        // BOBOT AHP
        // ---------------------------
        $bobotRows = Ahp::with('kriteria')->get();

        if ($bobotRows->isEmpty()) {
            return view('smart.index', $this->basePayload($periodes, $periodeAktif, $periodeId, $periodeSeleksi) + [
                'bobotBelumAda' => true,
            ]);
        }

        // ---------------------------
        // KRITERIA
        // ---------------------------
        $kriterias = Kriteria::orderBy('urutan')->get();

        $bobotMap = $bobotRows->mapWithKeys(fn ($row) => [
            $row->kriteria_id => $row->bobot,
        ]);

        // ---------------------------
        // SEMUA SISWA YANG PUNYA NILAI (untuk tabel seleksi)
        // ---------------------------
        $nilaiSemua = NilaiSiswa::with(['siswa', 'subKriteria.kriteria'])
            ->where('periode_id', $periodeId)
            ->get();

        if ($nilaiSemua->isEmpty()) {
            return view('smart.index', $this->basePayload($periodes, $periodeAktif, $periodeId, $periodeSeleksi) + [
                'bobotBelumAda'    => false,
                'nilaiBelumAda'    => true,
                'kriterias'        => $kriterias,
                'bobotMap'         => $bobotMap,
                'daftarSiswa'      => collect(),
            ]);
        }

        // Buat daftar siswa beserta nilai per kriteria (untuk tabel seleksi di view)
        $daftarSiswa = $this->buildTabelNilai($nilaiSemua, $kriterias);

        // ---------------------------
        // RIWAYAT TERAKHIR (opsional, untuk ditampilkan di halaman)
        // ---------------------------
        $riwayatTerakhir = Riwayat::where('jenis', 'smart')
            ->where('periode_id', $periodeId)
            ->orderByDesc('created_at')
            ->get();

        return view('smart.index', $this->basePayload($periodes, $periodeAktif, $periodeId, $periodeSeleksi) + [
            'bobotBelumAda'    => false,
            'nilaiBelumAda'    => false,
            'kriterias'        => $kriterias,
            'bobotMap'         => $bobotMap,
            'daftarSiswa'      => $daftarSiswa,
            'riwayatTerakhir'  => $riwayatTerakhir,
            // Hasil perhitungan kosong dulu (diisi setelah POST hitung)
            'tabelNilai'       => collect(),
            'tabelNormalisasi' => collect(),
            'tabelSkor'        => collect(),
            'minMax'           => [],
            'jumlahSiswa'      => 0,
            'sudahDihitung'    => false,
        ]);
    }

    // =========================================================
    //  HITUNG DAN SIMPAN — dipanggil saat user klik tombol Hitung
    //  Menerima siswa_ids[] yang dipilih user
    // =========================================================
    public function hitungDanSimpan(Request $request)
    {
        // ---------------------------
        // VALIDASI INPUT
        // ---------------------------
        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'siswa_ids'  => 'required|array|min:4',
            'siswa_ids.*'=> 'required|integer|exists:siswas,id',
        ], [
            'siswa_ids.required' => 'Pilih minimal 4 siswa untuk dihitung.',
            'siswa_ids.min'      => 'Pilih minimal 4 siswa untuk dihitung.',
        ]);

        $periodeId  = $request->periode_id;
        $siswaIds   = $request->siswa_ids; // array ID siswa yang dipilih

        // ---------------------------
        // PERIODE
        // ---------------------------
        $periodes       = Periode::orderByDesc('created_at')->get();
        $periodeAktif   = Periode::where('status', 'aktif')->first();
        $periodeSeleksi = $periodes->firstWhere('id', $periodeId);

        // ---------------------------
        // BOBOT AHP
        // ---------------------------
        $bobotRows = Ahp::with('kriteria')->get();
        $kriterias = Kriteria::orderBy('urutan')->get();

        $bobotMap = $bobotRows->mapWithKeys(fn ($row) => [
            $row->kriteria_id => $row->bobot,
        ]);

        // ---------------------------
        // NILAI — hanya siswa yang dipilih
        // ---------------------------
        $nilaiRows = NilaiSiswa::with(['siswa', 'subKriteria.kriteria'])
            ->where('periode_id', $periodeId)
            ->whereIn('siswa_id', $siswaIds)
            ->get();

        // ---------------------------
        // TABEL NILAI (rata-rata per kriteria per siswa)
        // ---------------------------
        $tabelNilai = $this->buildTabelNilai($nilaiRows, $kriterias);

        // Pastikan urutan siswa sesuai siswa_ids yang dipilih
        // (agar tidak ada ketidaksesuaian index)
        $tabelNilai = $tabelNilai->sortBy(fn ($row) => array_search($row['siswa_id'], $siswaIds))->values();

        // ---------------------------
        // MIN MAX PER KRITERIA
        // ---------------------------
        $minMax = [];
        foreach ($kriterias as $kriteria) {
            $nilaiKol = $tabelNilai->pluck("nilai.{$kriteria->id}");
            $minMax[$kriteria->id] = [
                'min' => $nilaiKol->min(),
                'max' => $nilaiKol->max(),
            ];
        }

        // ---------------------------
        // NORMALISASI UTILITY
        // ---------------------------
        $tabelNormalisasi = collect();

        foreach ($tabelNilai as $row) {
            $utility = [];

            foreach ($kriterias as $kriteria) {
                $nilai = $row['nilai'][$kriteria->id];
                $min   = $minMax[$kriteria->id]['min'];
                $max   = $minMax[$kriteria->id]['max'];

                if ($max == $min) {
                    // Semua nilai sama → utility = 1 (100%)
                    $u = 100;
                } elseif (($kriteria->tipe ?? 'benefit') === 'cost') {
                    $u = (($max - $nilai) / ($max - $min)) * 100;
                } else {
                    $u = (($nilai - $min) / ($max - $min)) * 100;
                }

                $utility[$kriteria->id] = round($u, 4);
            }

            $tabelNormalisasi->push([
                'siswa_id' => $row['siswa_id'],
                'nama'     => $row['nama'],
                'utility'  => $utility,
            ]);
        }

        // ---------------------------
        // SKOR AKHIR — bobot × utility
        // ---------------------------
        // Buat lookup nilai siswa berdasarkan siswa_id agar tidak salah index
        $nilaiLookup = $tabelNilai->keyBy('siswa_id');

        $tabelSkor = collect();

        foreach ($tabelNormalisasi as $row) {
            $detailSkor = [];
            $total      = 0;

            foreach ($kriterias as $kriteria) {
                $bobot   = $bobotMap[$kriteria->id] ?? 0;
                $utility = $row['utility'][$kriteria->id] ?? 0;
                $skor    = round($bobot * $utility, 4);

                $detailSkor[$kriteria->id] = $skor;
                $total += $skor;
            }

            $dataSiswa = $nilaiLookup[$row['siswa_id']];

            $tabelSkor->push([
                'siswa_id'          => $row['siswa_id'],
                'nama'              => $dataSiswa['nama'],
                'nis'               => $dataSiswa['nis'],
                'kelas'             => $dataSiswa['kelas'],
                'foto'              => $dataSiswa['foto'],
                'initials'          => $dataSiswa['initials'],
                'jenis_kelamin'     => $dataSiswa['jenis_kelamin'],
                'skor_per_kriteria' => $detailSkor,
                'total_skor'        => round($total, 4),
            ]);
        }

        $tabelSkor = $tabelSkor->sortByDesc('total_skor')->values();

        // ---------------------------
        // SIMPAN RIWAYAT
        // Selalu buat riwayat baru setiap kali tombol Hitung diklik
        // ---------------------------
        $juara = $tabelSkor->first();

Riwayat::create([
    'jenis'      => 'smart',
    'periode_id' => $periodeId,
    'user_id'    => Auth::id(),
    'judul'      => 'Perhitungan SMART — ' . optional($periodeSeleksi)->nama_periode,
    'keterangan' => 'Dihitung oleh ' . optional(Auth::user())->name
                    . ' | Siswa: ' . $tabelSkor->count()
                    . ' | Juara: ' . optional($juara)['nama'],
    'data_json'  => [
        // Info ringkas (untuk tampilan di index)
        'siswa_terbaik'   => optional($juara)['nama'],
        'skor_tertinggi'  => optional($juara)['total_skor'],
        'jumlah_siswa'    => $tabelSkor->count(),

        // Data lengkap (untuk tampilan di show/detail)
        'kriterias'          => $kriterias->map(fn($k) => [
            'id'   => $k->id,
            'kode' => $k->kode,
            'nama' => $k->nama,
            'tipe' => $k->tipe,
        ])->values()->toArray(),

        'bobot_map'          => $bobotMap->toArray(),

        'tabel_nilai'        => $tabelNilai->map(fn($row) => [
            'siswa_id' => $row['siswa_id'],
            'nama'     => $row['nama'],
            'nis'      => $row['nis'],
            'kelas'    => $row['kelas'],
            'nilai'    => $row['nilai'],
        ])->values()->toArray(),

        'tabel_normalisasi'  => $tabelNormalisasi->map(fn($row) => [
            'siswa_id' => $row['siswa_id'],
            'nama'     => $row['nama'],
            'utility'  => $row['utility'],
        ])->values()->toArray(),

        'min_max'            => $minMax,
        'siswa_ids'          => $siswaIds,

        'tabel_skor'         => $tabelSkor->map(fn($row) => [
            'siswa_id'          => $row['siswa_id'],
            'nama'              => $row['nama'],
            'nis'               => $row['nis'],
            'kelas'             => $row['kelas'],
            'skor_per_kriteria' => $row['skor_per_kriteria'],
            'total_skor'        => $row['total_skor'],
        ])->values()->toArray(),
    ],
]);

        // ---------------------------
        // SEMUA SISWA (untuk tabel seleksi tetap tampil)
        // ---------------------------
        $nilaiSemua  = NilaiSiswa::with(['siswa', 'subKriteria.kriteria'])
            ->where('periode_id', $periodeId)
            ->get();
        $daftarSiswa = $this->buildTabelNilai($nilaiSemua, $kriterias);

        $riwayatTerakhir = Riwayat::where('jenis', 'smart')
            ->where('periode_id', $periodeId)
            ->orderByDesc('created_at')
            ->get();

        return view('smart.index', $this->basePayload($periodes, $periodeAktif, $periodeId, $periodeSeleksi) + [
            'bobotBelumAda'    => false,
            'nilaiBelumAda'    => false,
            'kriterias'        => $kriterias,
            'bobotMap'         => $bobotMap,
            'daftarSiswa'      => $daftarSiswa,
            'riwayatTerakhir'  => $riwayatTerakhir,
            'tabelNilai'       => $tabelNilai,
            'tabelNormalisasi' => $tabelNormalisasi,
            'tabelSkor'        => $tabelSkor,
            'minMax'           => $minMax,
            'jumlahSiswa'      => $tabelSkor->count(),
            'sudahDihitung'    => true,
            'siswaIdsDipilih'  => $siswaIds,
        ]);
    }

    // =========================================================
    //  HELPER — bangun tabel nilai rata-rata per kriteria per siswa
    // =========================================================
    private function buildTabelNilai($nilaiRows, $kriterias): \Illuminate\Support\Collection
    {
        $tabel = collect();

        foreach ($nilaiRows->groupBy('siswa_id') as $siswaId => $rows) {
            $siswa = $rows->first()->siswa;

            if (! $siswa) {
                continue;
            }

            $nilaiPerKriteria = [];

            foreach ($kriterias as $kriteria) {
                $nilaiKriteria = $rows
                    ->filter(fn ($r) => optional($r->subKriteria)->kriteria_id == $kriteria->id)
                    ->pluck('nilai');

                $nilaiPerKriteria[$kriteria->id] = $nilaiKriteria->count()
                    ? round($nilaiKriteria->avg(), 4)
                    : 0;
            }

            $tabel->push([
                'siswa_id'      => $siswa->id,
                'nama'          => $siswa->nama,
                'nis'           => $siswa->nis,
                'kelas'         => $siswa->kelas,
                'foto'          => $siswa->foto ?? null,
                'initials'      => $siswa->initials ?? strtoupper(substr($siswa->nama, 0, 2)),
                'jenis_kelamin' => $siswa->jenis_kelamin,
                'nilai'         => $nilaiPerKriteria,
            ]);
        }

        return $tabel;
    }

    // =========================================================
    //  HELPER — payload dasar yang selalu dikirim ke view
    // =========================================================
    private function basePayload($periodes, $periodeAktif, $periodeId, $periodeSeleksi): array
    {
        return [
            'periodes'       => $periodes,
            'periodeAktif'   => $periodeAktif,
            'periodeId'      => $periodeId,
            'periodeSeleksi' => $periodeSeleksi,
        ];
    }
}