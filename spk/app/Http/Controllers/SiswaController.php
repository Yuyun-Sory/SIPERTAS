<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Periode;
use App\Models\Kriteria;
use App\Models\Riwayat;
use App\Models\Ahp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class SiswaController extends Controller
{
    /*
    |==========================================================================
    | INDEX
    |==========================================================================
    | GET /siswa
    | Menampilkan daftar siswa dengan filter pencarian & kelas.
    | Menyertakan variabel $jumlahSudahHitung untuk stat card di view.
    |==========================================================================
    */
    public function index(Request $request)
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();
        $periodes     = Periode::orderByDesc('created_at')->get();

        $query = Siswa::with('nilaiSiswas')
            ->when(
                $request->filled('search'),
                fn ($q) => $q->where(function ($q) use ($request) {
                    $q->where('nama',  'like', "%{$request->search}%")
                      ->orWhere('nis', 'like', "%{$request->search}%");
                })
            )
            ->when(
                $request->filled('kelas'),
                fn ($q) => $q->where('kelas', $request->kelas)
            )
            ->orderBy('kelas')
            ->orderBy('nama');

        $siswas    = $query->get();
        $kelasList = Siswa::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        // Untuk stat card "Sudah Nilai"
        $jumlahSudahInput = $siswas->filter(fn ($s) => $s->nilaiSiswas->count() > 0)->count();
        $jumlahBelumInput = $siswas->filter(fn ($s) => $s->nilaiSiswas->count() === 0)->count();

        // Untuk stat card "Sudah Dihitung" (kolom status_hitung di tabel siswas)
        $jumlahSudahHitung = $siswas->filter(fn ($s) => $s->status_hitung)->count();

        return view('siswa.index', compact(
            'siswas',
            'periodes',
            'periodeAktif',
            'kelasList',
            'jumlahSudahInput',
            'jumlahBelumInput',
            'jumlahSudahHitung',   // ← dipakai stat card ke-3 di blade
        ));
    }

    /*
    |==========================================================================
    | CREATE
    |==========================================================================
    | GET /siswa/create
    */
    public function create()
    {
        $kelasList = $this->getKelasList();

        return view('siswa.create', compact('kelasList'));
    }

    /*
    |==========================================================================
    | STORE
    |==========================================================================
    | POST /siswa
    */
  public function store(Request $request)
    {
        $validated = $request->validate([
            'nis'           => ['required', 'string', 'max:20', 'unique:siswas,nis'],
            'nama'          => ['required', 'string', 'max:100'],
            'kelas'         => ['required', 'string', 'max:20'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'foto'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('siswa', 'public');
        }

        $siswa = Siswa::create([
            'nis'            => $validated['nis'],
            'nama'           => $validated['nama'],
            'kelas'          => $validated['kelas'],
            'jenis_kelamin'  => $validated['jenis_kelamin'],
            'foto'           => $fotoPath,
            'status_hitung'  => false,  // default belum dihitung
        ]);

        return redirect()->route('siswa.index')
            ->with('success', "Siswa <strong>{$siswa->nama}</strong> berhasil ditambahkan. "
                            . "Silakan minta Wali Kelas untuk menginput nilai.");
    }

    /*
    |==========================================================================
    | SHOW
    |==========================================================================
    | GET /siswa/{siswa}
    */
    public function show(Siswa $siswa)
    {
        $nilaiByPeriode = $siswa->nilaiSiswas()
            ->with(['periode', 'subKriteria.kriteria'])
            ->get()
            ->groupBy('periode_id');

        $periodes  = Periode::orderByDesc('created_at')->get();
        $kriterias = Kriteria::with('subKriterias')->orderBy('kode')->get();

        return view('siswa.show', compact(
            'siswa',
            'nilaiByPeriode',
            'periodes',
            'kriterias'
        ));
    }

    /*
    |==========================================================================
    | EDIT
    |==========================================================================
    | GET /siswa/{siswa}/edit
    */
    public function edit(Siswa $siswa)
    {
        $kelasList = $this->getKelasList();

        return view('siswa.edit', compact('siswa', 'kelasList'));
    }

    /*
    |==========================================================================
    | UPDATE
    |==========================================================================
    | PUT /siswa/{siswa}
    */
    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis'           => ['required', 'string', 'max:20',
                                Rule::unique('siswas', 'nis')->ignore($siswa->id)],
            'nama'          => ['required', 'string', 'max:100'],
            'kelas'         => ['required', 'string', 'max:20'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'foto'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $validated['foto'] = $request->file('foto')->store('siswa', 'public');
        } else {
            $validated['foto'] = $siswa->foto;
        }

        $siswa->update($validated);

        return redirect()->route('siswa.index')
            ->with('success', "Data siswa <strong>{$siswa->nama}</strong> berhasil diperbarui.");
    }

    /*
    |==========================================================================
    | DESTROY (single)
    |==========================================================================
    | DELETE /siswa/{siswa}
    */
    public function destroy(Siswa $siswa)
    {
        DB::beginTransaction();
        try {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }

            $siswa->nilaiSiswas()->delete();
            $siswa->delete();

            DB::commit();

            return redirect()->route('siswa.index')
                ->with('success', "Siswa <strong>{$siswa->nama}</strong> berhasil dihapus.");

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /*
    |==========================================================================
    | HITUNG BULK — Hitung & Simpan
    |==========================================================================
    | POST /siswa/hitung-bulk
    | Route name : siswa.hitungBulk
    |
    | Alur:
    |   1. Terima siswa_ids (string "1,2,3") dari form di siswa/index.blade.php
    |   2. Validasi: minimal 1 ID, semua harus punya nilai
    |   3. Ambil bobot AHP dari tabel kriterias (kolom bobot)
    |   4. Hitung nilai utility SMART per siswa per kriteria
    |   5. Hitung skor akhir SMART = Σ (bobot_k × utility_k)
    |   6. Update status_hitung = true untuk siswa yang dihitung
    |   7. Simpan satu baris riwayat berisi semua hasil ke tabel riwayats
    |   8. Redirect ke smart.index dengan pesan sukses
    |==========================================================================
    */
    public function hitungBulk(Request $request)
    {
        // ── 1. Validasi input ────────────────────────────────────────────────
        $request->validate([
            'siswa_ids' => ['required', 'string'],
        ]);

        // Parse "1,2,3" → [1, 2, 3] (buang nilai 0/kosong)
        $ids = array_values(
            array_filter(
                array_map('intval', explode(',', $request->siswa_ids))
            )
        );

        if (empty($ids)) {
            return redirect()->route('siswa.index')
                ->with('error', 'Tidak ada siswa yang dipilih. Centang minimal 1 siswa.');
        }

        // ── 2. Ambil data siswa beserta nilainya ─────────────────────────────
        $siswas = Siswa::with('nilaiSiswas.subKriteria.kriteria')
                       ->whereIn('id', $ids)
                       ->get();

        if ($siswas->isEmpty()) {
            return redirect()->route('siswa.index')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        // Cek apakah semua siswa sudah punya nilai
        $belumNilai = $siswas->filter(fn ($s) => $s->nilaiSiswas->isEmpty());
        if ($belumNilai->isNotEmpty()) {
            $namaList = $belumNilai->pluck('nama')->implode(', ');
            return redirect()->route('siswa.index')
                ->with('error', "Siswa berikut belum memiliki nilai: <strong>{$namaList}</strong>. "
                              . "Input nilai terlebih dahulu.");
        }

        // ── 3. Ambil bobot AHP dari tabel kriterias ──────────────────────────
        // Kolom 'bobot' diisi oleh AhpController saat admin menghitung AHP.
$kriterias = Kriteria::with('ahp')
    ->orderBy('urutan')
    ->get();
        if ($kriterias->isEmpty()) {
            return redirect()->route('siswa.index')
                ->with('error', 'Belum ada data kriteria. Tambahkan kriteria terlebih dahulu.');
        }

        // Pastikan semua kriteria sudah punya bobot AHP
$belumBobot = $kriterias->filter(function ($k) {
    return !$k->ahp || $k->ahp->bobot <= 0;
});        if ($belumBobot->isNotEmpty()) {
            return redirect()->route('siswa.index')
                ->with('error', 'Bobot AHP belum dihitung. Buka menu <strong>AHP</strong> '
                              . 'dan hitung bobot terlebih dahulu.');
        }

        // ── 4. Hitung nilai SMART ─────────────────────────────────────────────
        //
        // Metode SMART (Simple Multi-Attribute Rating Technique):
        //
        //   Langkah A — Normalisasi nilai (utility) per kriteria:
        //     utility_ij = (x_ij − x_min_j) / (x_max_j − x_min_j) × 100
        //     Khusus sifat "cost" (minimisasi):
        //     utility_ij = (x_max_j − x_ij) / (x_max_j − x_min_j) × 100
        //
        //   Langkah B — Hitung skor akhir:
        //     V_i = Σ (w_j × utility_ij)
        //     di mana w_j = bobot AHP kriteria ke-j (sudah 0–1, jumlah = 1)
        //
        // Nilai per siswa per kriteria diambil dari nilaiSiswas → subKriteria → kriteria.
        // Jika satu kriteria punya banyak sub-kriteria, nilai yang dipakai adalah
        // rata-rata nilai sub-kriteria dalam kriteria tersebut.
        // ─────────────────────────────────────────────────────────────────────

        // Kumpulkan nilai per siswa per kriteria (rata-rata sub-kriteria)
        // Struktur: $nilaiMatrix[siswa_id][kriteria_id] = rata_rata_nilai
        $nilaiMatrix = [];

        foreach ($siswas as $siswa) {
            foreach ($kriterias as $kriteria) {
                // Ambil semua nilai sub-kriteria yang berada di bawah kriteria ini
                $nilaiSubKriteria = $siswa->nilaiSiswas
                    ->filter(fn ($n) => optional($n->subKriteria)->kriteria_id === $kriteria->id)
                    ->pluck('nilai');

                // Rata-rata; jika tidak ada nilai → 0
                $nilaiMatrix[$siswa->id][$kriteria->id] = $nilaiSubKriteria->isNotEmpty()
                    ? round($nilaiSubKriteria->avg(), 4)
                    : 0;
            }
        }

        // Hitung min & max per kriteria dari SELURUH siswa yang dihitung
        $minMax = [];
        foreach ($kriterias as $kriteria) {
            $nilaiKolom = array_column($nilaiMatrix, $kriteria->id);
            $minMax[$kriteria->id] = [
                'min' => min($nilaiKolom),
                'max' => max($nilaiKolom),
            ];
        }

        // Hitung utility & skor akhir per siswa
        $hasilSmart = [];

        foreach ($siswas as $siswa) {
            $skorAkhir  = 0;
            $detailUtil = [];

            foreach ($kriterias as $kriteria) {
                $nilai = $nilaiMatrix[$siswa->id][$kriteria->id];
                $min   = $minMax[$kriteria->id]['min'];
                $max   = $minMax[$kriteria->id]['max'];

                // Hindari pembagian nol (semua nilai sama)
                if ($max === $min) {
                    $utility = 100;
                } else {
                    // Sifat kriteria: 'benefit' (maksimasi) atau 'cost' (minimisasi)
                    $sifat = strtolower($kriteria->sifat ?? 'benefit');
                    if ($sifat === 'cost') {
                        $utility = round(($max - $nilai) / ($max - $min) * 100, 4);
                    } else {
                        $utility = round(($nilai - $min) / ($max - $min) * 100, 4);
                    }
                }

$bobot = $kriteria->ahp->bobot;

$skorAkhir += $bobot * $utility;
                $detailUtil[] = [
                    'kriteria_id'   => $kriteria->id,
                    'kriteria_kode' => $kriteria->kode,
                    'kriteria_nama' => $kriteria->nama,
                    'bobot'         => $kriteria->bobot,
                    'nilai_asli'    => $nilai,
                    'nilai_min'     => $min,
                    'nilai_max'     => $max,
                    'utility'       => $utility,
                    'kontribusi'    => round($kriteria->bobot * $utility, 4),
                ];
            }

            $hasilSmart[] = [
                'siswa_id'    => $siswa->id,
                'siswa_nama'  => $siswa->nama,
                'siswa_nis'   => $siswa->nis,
                'kelas'       => $siswa->kelas,
                'skor_akhir'  => round($skorAkhir, 4),
                'detail'      => $detailUtil,
            ];
        }

        // Urutkan descending berdasarkan skor akhir (peringkat 1 = terbaik)
        usort($hasilSmart, fn ($a, $b) => $b['skor_akhir'] <=> $a['skor_akhir']);

        // Tambahkan kolom peringkat
        foreach ($hasilSmart as $i => &$hasil) {
            $hasil['peringkat'] = $i + 1;
        }
        unset($hasil);

        // ── 5. Simpan ke DB dalam satu transaksi ────────────────────────────
        DB::beginTransaction();
        try {
            // Update status_hitung = true untuk semua siswa yang dihitung
// tandai siswa yang dipilih
Siswa::whereIn('id', $ids)->update([
    'status_hitung' => true
]);
            // Ambil periode aktif (boleh null jika belum ada)
            $periodeAktif = Periode::where('status', 'aktif')->first();

            // Simpan satu baris riwayat yang merangkum semua siswa & hasil
            $riwayat = Riwayat::create([
                'jenis'      => 'smart',
                'periode_id' => $periodeAktif?->id,
                'user_id'    => Auth::id(),
                'judul'      => 'SPK SMART – ' . count($ids) . ' Siswa – '
                              . now()->format('d/m/Y H:i'),
                'keterangan' => 'Perhitungan SMART dengan bobot AHP untuk '
                              . count($ids) . ' siswa: '
                              . collect($hasilSmart)->pluck('siswa_nama')->implode(', ') . '.',
                'siswa_ids'  => json_encode($ids),
                'data_json'  => json_encode([
                    'dihitung_pada' => now()->toDateTimeString(),
                    'dihitung_oleh' => Auth::user()?->name,
                    'jumlah_siswa'  => count($ids),
                    'periode'       => $periodeAktif?->nama ?? '-',
                    'hasil'         => $hasilSmart,
                    'bobot_ahp'     => $kriterias->map(fn ($k) => [
                        'id'    => $k->id,
                        'kode'  => $k->kode,
                        'nama'  => $k->nama,
                        'bobot' => $k->bobot,
                    ])->toArray(),
                ]),
            ]);

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->route('siswa.index')
                ->with('error', 'Gagal menyimpan hasil perhitungan: ' . $e->getMessage());
        }

        // ── 6. Redirect ke halaman SMART dengan pesan sukses ────────────────
        return redirect()->route('smart.index')
            ->with('success', count($ids) . ' siswa berhasil dihitung dan hasil disimpan ke riwayat. '
                            . '<a href="' . route('riwayat.show', $riwayat->id) . '" '
                            . 'style="text-decoration:underline">Lihat Riwayat →</a>');
    }

    /*
    |==========================================================================
    | DESTROY BULK
    |==========================================================================
    | DELETE /siswa/hapus-bulk
    | Route name : siswa.destroyBulk
    |
    | Alur:
    |   1. Terima siswa_ids (string "1,2,3") dari form di siswa/index.blade.php
    |   2. Parse → array integer, buang nol/kosong
    |   3. Hapus foto dari storage untuk tiap siswa yang punya foto
    |   4. Hapus nilaiSiswas terkait (jika tidak pakai cascade di FK)
    |   5. Hapus siswa
    |   6. Redirect ke siswa.index dengan pesan sukses
    |==========================================================================
    */
    public function destroyBulk(Request $request)
    {
        // ── 1. Validasi ──────────────────────────────────────────────────────
        $request->validate([
            'siswa_ids' => ['required', 'string'],
        ]);

        $ids = array_values(
            array_filter(
                array_map('intval', explode(',', $request->siswa_ids))
            )
        );

        if (empty($ids)) {
            return redirect()->route('siswa.index')
                ->with('error', 'Tidak ada siswa yang dipilih untuk dihapus.');
        }

        // ── 2. Ambil siswa (untuk hapus foto) ────────────────────────────────
        $siswas = Siswa::whereIn('id', $ids)->get();

        if ($siswas->isEmpty()) {
            return redirect()->route('siswa.index')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $jumlah = $siswas->count();

        // ── 3. Hapus dalam transaksi ─────────────────────────────────────────
        DB::beginTransaction();
        try {
            foreach ($siswas as $siswa) {
                // Hapus foto dari storage
                if ($siswa->foto) {
                    Storage::disk('public')->delete($siswa->foto);
                }

                // Hapus nilai terkait (eksplisit; jaga-jaga jika FK belum cascade)
                $siswa->nilaiSiswas()->delete();

                // Hapus siswa
                $siswa->delete();
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->route('siswa.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }

        return redirect()->route('siswa.index')
            ->with('success', "<strong>{$jumlah} siswa</strong> berhasil dihapus beserta semua nilai terkait.");
    }

    /*
    |==========================================================================
    | HITUNG SIMPAN (lama — single siswa, dipertahankan untuk kompatibilitas)
    |==========================================================================
    | POST /siswa/{id}/hitung-simpan   ← sudah DIHAPUS dari web.php
    |
    | Method ini dipertahankan jika suatu saat diperlukan kembali (misalnya
    | dipanggil dari halaman siswa.show untuk hitung satu siswa saja).
    | Jika tidak diperlukan, method ini boleh dihapus.
    |==========================================================================
    */
    public function hitungSimpan(Request $request, $id)
    {
        $siswa = Siswa::with('nilaiSiswas')->findOrFail($id);

        if ($siswa->nilaiSiswas->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa belum memiliki nilai. Input nilai terlebih dahulu.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            $periodeAktif = Periode::where('status', 'aktif')->first();

            $dataJson = [
                'siswa_id'      => $siswa->id,
                'siswa_nama'    => $siswa->nama,
                'siswa_nis'     => $siswa->nis,
                'kelas'         => $siswa->kelas,
                'nilai'         => $siswa->nilaiSiswas->map(fn ($n) => [
                    'sub_kriteria_id' => $n->sub_kriteria_id,
                    'nilai'           => $n->nilai,
                    'periode_id'      => $n->periode_id,
                ])->toArray(),
                'dihitung_pada' => now()->toDateTimeString(),
            ];

            $riwayat = Riwayat::create([
                'jenis'      => 'smart',
                'periode_id' => $periodeAktif?->id,
                'user_id'    => Auth::id(),
                'judul'      => 'SPK – ' . $siswa->nama . ' – ' . now()->format('d/m/Y H:i'),
                'keterangan' => 'Perhitungan SMART dengan bobot AHP untuk siswa '
                              . $siswa->nama . ' (' . $siswa->nis . ') kelas ' . $siswa->kelas . '.',
                'siswa_ids'  => json_encode([$siswa->id]),
                'data_json'  => json_encode($dataJson),
            ]);

            // Tandai sudah dihitung
            $siswa->update(['status_hitung' => true]);

            DB::commit();

            return response()->json([
                'success'    => true,
                'riwayat_id' => $riwayat->id,
                'message'    => 'Berhasil disimpan.',
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /*
    |==========================================================================
    | HELPERS
    |==========================================================================
    */

    /**
     * Daftar kelas yang tersedia untuk dropdown form tambah/edit siswa.
     * Sesuaikan dengan jenjang sekolah Anda (SD, SMP, SMA, SMK, dll).
     */
    private function getKelasList(): array
    {
        return [
            'VII A', 'VII B', 'VII C',
            'VIII A', 'VIII B', 'VIII C',
            'IX A', 'IX B', 'IX C',
        ];
    }
}