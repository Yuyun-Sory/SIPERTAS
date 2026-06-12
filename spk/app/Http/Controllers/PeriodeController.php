<?php

namespace App\Http\Controllers;

use App\Models\NilaiSiswa;
use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = Periode::orderByRaw("status = 'aktif' DESC")
                           ->orderBy('tanggal_mulai', 'desc')
                           ->get();
        return view('periode.index', compact('periodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_periode'    => 'required|string|max:100',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'keterangan'      => 'nullable|string|max:255',
        ], [
            'nama_periode.required'    => 'Nama periode wajib diisi.',
            'tanggal_mulai.required'   => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after'    => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        // ──────────────────────────────────────────────────────
        // Nonaktifkan semua periode lama
        // ──────────────────────────────────────────────────────
        Periode::where('status', 'aktif')->update(['status' => 'nonaktif']);

        // ──────────────────────────────────────────────────────
        // Buat periode baru
        // ──────────────────────────────────────────────────────
        $periode = Periode::create([
            'nama_periode'    => $request->nama_periode,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status'          => 'aktif',
            'keterangan'      => $request->keterangan,
        ]);

        NilaiSiswa::where('periode_id', '!=', $periode->id)->delete();

        return redirect()->route('periode.index')
                         ->with('success', 'Periode <strong>' . e($periode->nama_periode) . '</strong> berhasil dibuat dan semua nilai periode sebelumnya telah dihapus.');
    }

    public function update(Request $request, Periode $periode)
    {
        // Periode nonaktif tidak dapat diedit
        if ($periode->status === 'nonaktif') {
            return redirect()->route('periode.index')
                             ->with('error', 'Periode nonaktif tidak dapat diedit.');
        }

        $request->validate([
            'nama_periode'    => 'required|string|max:100',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'keterangan'      => 'nullable|string|max:255',
        ], [
            'nama_periode.required'    => 'Nama periode wajib diisi.',
            'tanggal_mulai.required'   => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after'    => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        $periode->update([
            'nama_periode'    => $request->nama_periode,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status'          => 'aktif',
            'keterangan'      => $request->keterangan,
        ]);

        return redirect()->route('periode.index')
                         ->with('success', 'Periode berhasil diperbarui.');
    }

    public function destroy(Periode $periode)
    {
        if ($periode->status === 'nonaktif') {
            return redirect()->route('periode.index')
                             ->with('error', 'Periode nonaktif tidak dapat dihapus.');
        }

        if ($periode->status === 'aktif') {
            return redirect()->route('periode.index')
                             ->with('error', 'Periode aktif tidak dapat dihapus.');
        }

        $periode->delete();
        return redirect()->route('periode.index')
                         ->with('success', 'Periode berhasil dihapus.');
    }

    public function aktivasi(Periode $periode)
    {
        Periode::where('status', 'aktif')->update(['status' => 'nonaktif']);
        $periode->update(['status' => 'aktif']);
        return redirect()->route('periode.index')
                         ->with('success', "Periode \"{$periode->nama_periode}\" berhasil diaktifkan.");
    }
}