<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KriteriaController extends Controller
{
    /* ────────────────────────────────────────────────────────────
     |  INDEX – tampilkan semua kriteria beserta sub-kriteria
     * ────────────────────────────────────────────────────────── */
    public function index()
    {
        $kriterias = Kriteria::with('subKriterias')
                             ->orderBy('urutan')
                             ->get();

        $stats = [
            'total'   => $kriterias->count(),
            'benefit' => $kriterias->where('tipe', 'benefit')->count(),
            'cost'    => $kriterias->where('tipe', 'cost')->count(),
            'sub'     => $kriterias->sum(fn ($k) => $k->subKriterias->count()),
        ];

        return view('kriteria.index', compact('kriterias', 'stats'));
    }

    /* ────────────────────────────────────────────────────────────
     |  STORE – simpan kriteria baru + 4 sub-kriteria
     * ────────────────────────────────────────────────────────── */
    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:100',
            'tipe'           => 'required|in:benefit,cost',
            'deskripsi'      => 'nullable|string|max:500',
            'subs'           => 'required|array|size:4',
            'subs.*.level'   => 'required|integer|between:1,4',
            'subs.*.nama'    => 'required|string|max:100',
            'subs.*.deskripsi' => 'nullable|string|max:300',
        ]);

        DB::transaction(function () use ($request) {
            $urutan = Kriteria::max('urutan') + 1;

            $kriteria = Kriteria::create([
                'kode'      => Kriteria::generateKode(),
                'nama'      => $request->nama,
                'tipe'      => $request->tipe,
                'deskripsi' => $request->deskripsi,
                'urutan'    => $urutan,
            ]);

            foreach ($request->subs as $sub) {
                SubKriteria::create([
                    'kriteria_id' => $kriteria->id,
                    'level'       => $sub['level'],
                    'nama'        => $sub['nama'],
                    'deskripsi'   => $sub['deskripsi'] ?? null,
                ]);
            }
        });

        return redirect()->route('kriteria.index')
                         ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    /* ────────────────────────────────────────────────────────────
     |  UPDATE – perbarui kriteria + sync sub-kriteria
     * ────────────────────────────────────────────────────────── */
    public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'nama'             => 'required|string|max:100',
            'tipe'             => 'required|in:benefit,cost',
            'deskripsi'        => 'nullable|string|max:500',
            'subs'             => 'required|array|size:4',
            'subs.*.level'     => 'required|integer|between:1,4',
            'subs.*.nama'      => 'required|string|max:100',
            'subs.*.deskripsi' => 'nullable|string|max:300',
        ]);

        DB::transaction(function () use ($request, $kriteria) {
            $kriteria->update([
                'nama'      => $request->nama,
                'tipe'      => $request->tipe,
                'deskripsi' => $request->deskripsi,
            ]);

            // Hapus lama, buat baru (sync sederhana)
            $kriteria->subKriterias()->delete();

            foreach ($request->subs as $sub) {
                SubKriteria::create([
                    'kriteria_id' => $kriteria->id,
                    'level'       => $sub['level'],
                    'nama'        => $sub['nama'],
                    'deskripsi'   => $sub['deskripsi'] ?? null,
                ]);
            }
        });

        return redirect()->route('kriteria.index')
                         ->with('success', 'Kriteria berhasil diperbarui.');
    }

    /* ────────────────────────────────────────────────────────────
     |  DESTROY – hapus kriteria + re-urut kode
     * ────────────────────────────────────────────────────────── */
    public function destroy(Kriteria $kriteria)
    {
        DB::transaction(function () use ($kriteria) {
            $kriteria->subKriterias()->delete();
            $kriteria->delete();
            Kriteria::reorderKode();
        });

        return redirect()->route('kriteria.index')
                         ->with('success', 'Kriteria berhasil dihapus.');
    }

    /* ────────────────────────────────────────────────────────────
     |  GET JSON – untuk kebutuhan AJAX (opsional)
     * ────────────────────────────────────────────────────────── */
    public function show(Kriteria $kriteria)
    {
        return response()->json($kriteria->load('subKriterias'));
    }
}
