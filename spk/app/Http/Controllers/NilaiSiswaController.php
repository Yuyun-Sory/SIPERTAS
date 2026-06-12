<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\NilaiSiswa;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class NilaiSiswaController extends Controller
{
    public function index(Request $request)
{
    $periodeAktif = Periode::where('status', 'aktif')->first();

    $query = Siswa::orderBy('kelas')->orderBy('nama');

    // Wali kelas hanya lihat kelasnya sendiri
    if (Auth::user()->role === 'wali_kelas') {
        $query->where('kelas', Auth::user()->kelas);
    }

    $siswas = $query->get();

    $sudahDiinput = $periodeAktif
        ? NilaiSiswa::where('periode_id', $periodeAktif->id)->pluck('siswa_id')->unique()
        : collect();

    $jumlahSudah = $sudahDiinput->count();
    $jumlahBelum = $siswas->count() - $jumlahSudah;

    return view('nilai.index', compact(
        'siswas', 'periodeAktif', 'sudahDiinput', 'jumlahSudah', 'jumlahBelum'
    ));
}

    public function create(Siswa $siswa, Request $request)
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();
        $periodes     = Periode::orderByDesc('created_at')->get();
        $kriterias    = Kriteria::with('subKriterias')->orderBy('kode')->get();
        $periodeId    = $request->get('periode_id', optional($periodeAktif)->id);

        // Cek apakah nilai sudah ada
        $sudahAda = NilaiSiswa::where('siswa_id', $siswa->id)
            ->where('periode_id', $periodeId)
            ->exists();

        if ($sudahAda) {
            return redirect()->route('nilai.edit', [$siswa, 'periode_id' => $periodeId])
                ->with('info', 'Nilai sudah ada, silakan edit nilai yang ada.');
        }

        return view('nilai.create', compact(
            'siswa', 'kriterias', 'periodes', 'periodeAktif', 'periodeId'
        ));
    }

    public function store(Siswa $siswa, Request $request)
    {
        $validated = $request->validate([
            'periode_id' => ['required', 'exists:periodes,id'],
            'nilai'      => ['required', 'array'],
            'nilai.*'    => ['required', 'integer', 'min:1', 'max:4'],
        ]);

        DB::beginTransaction();
        try {
            $nilaiData = [];
            foreach ($validated['nilai'] as $kriteriaId => $level) {
                $sub = SubKriteria::where('kriteria_id', $kriteriaId)
                    ->where('level', $level)->first();

                if (!$sub) {
                    throw new \Exception("Sub-kriteria tidak ditemukan (Kriteria ID: {$kriteriaId}, Level: {$level})");
                }

                $nilaiData[] = [
                    'siswa_id'        => $siswa->id,
                    'sub_kriteria_id' => $sub->id,
                    'periode_id'      => $validated['periode_id'],
                    'nilai'           => $level,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
            }

            NilaiSiswa::insert($nilaiData);
            DB::commit();

            return redirect()->route('nilai.index')
                ->with('success', "Nilai <strong>{$siswa->nama}</strong> berhasil disimpan.");

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function edit(Siswa $siswa, Request $request)
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();
        $periodes     = Periode::orderByDesc('created_at')->get();
        $kriterias    = Kriteria::with('subKriterias')->orderBy('kode')->get();
        $periodeId    = $request->get('periode_id', optional($periodeAktif)->id);

        // ✅ Map kriteria_id => level (bukan sub_kriteria_id => nilai)
        $nilaiRows = NilaiSiswa::where('siswa_id', $siswa->id)
            ->where('periode_id', $periodeId)
            ->with('subKriteria')
            ->get();

        $nilaiSiswa = $nilaiRows->mapWithKeys(function ($row) {
            return [$row->subKriteria->kriteria_id => $row->nilai];
        });

        return view('nilai.edit', compact(
            'siswa', 'kriterias', 'nilaiSiswa', 'periodes', 'periodeAktif', 'periodeId'
        ));
    }

    public function update(Siswa $siswa, Request $request)
    {
        $validated = $request->validate([
            'periode_id' => ['required', 'exists:periodes,id'],
            'nilai'      => ['required', 'array'],
            'nilai.*'    => ['required', 'integer', 'min:1', 'max:4'],
        ]);

        DB::beginTransaction();
        try {
            // Hapus nilai lama
            NilaiSiswa::where('siswa_id', $siswa->id)
                ->where('periode_id', $validated['periode_id'])
                ->delete();

            $nilaiData = [];
            foreach ($validated['nilai'] as $kriteriaId => $level) {
                $sub = SubKriteria::where('kriteria_id', $kriteriaId)
                    ->where('level', $level)->first();

                if (!$sub) throw new \Exception("Sub-kriteria tidak ditemukan");

                $nilaiData[] = [
                    'siswa_id'        => $siswa->id,
                    'sub_kriteria_id' => $sub->id,
                    'periode_id'      => $validated['periode_id'],
                    'nilai'           => $level,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
            }

            NilaiSiswa::insert($nilaiData);
            DB::commit();

            return redirect()->route('nilai.index')
                ->with('success', "Nilai <strong>{$siswa->nama}</strong> berhasil diperbarui.");

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function show(Siswa $siswa)
{
    $nilaiByPeriode = $siswa->nilaiSiswas()
        ->with(['periode', 'subKriteria.kriteria'])
        ->get()
        ->groupBy('periode_id');

    // 🔥 TAMBAHAN WAJIB
    $periodes  = \App\Models\Periode::orderByDesc('created_at')->get();
    $kriterias = \App\Models\Kriteria::with('subKriterias')->get();

    return view('siswa.show', compact(
        'siswa',
        'nilaiByPeriode',
        'periodes',
        'kriterias'
    ));
}

}