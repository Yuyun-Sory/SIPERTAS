<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use App\Models\Periode;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    // =========================================================
    //  INDEX — tampilkan daftar riwayat dengan filter
    // =========================================================
    public function index(Request $request)
    {
        $periodes = Periode::orderByDesc('created_at')->get();

        $query = Riwayat::with(['periode', 'user'])
            ->orderByDesc('created_at');

        // Filter jenis (smart / ahp / nilai)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter periode
        if ($request->filled('periode_id')) {
            $query->where('periode_id', $request->periode_id);
        }

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Pagination — 15 per halaman, tetap bawa query string filter
        $riwayats = $query->paginate(15)->withQueryString();

        // Statistik — tidak terpengaruh filter, menampilkan total global
        $totalSmart = Riwayat::where('jenis', 'smart')->count();
        $totalAhp   = Riwayat::where('jenis', 'ahp')->count();
        $totalNilai = Riwayat::where('jenis', 'nilai')->count();
        $totalSemua = $totalSmart + $totalAhp + $totalNilai;

        return view('riwayat.index', compact(
            'riwayats',
            'periodes',
            'totalSmart',
            'totalAhp',
            'totalNilai',
            'totalSemua',
        ));
    }

    // =========================================================
    //  SHOW — detail satu riwayat, data_json sudah di-decode
    // =========================================================
    public function show(Riwayat $riwayat)
    {
        $riwayat->load(['periode', 'user']);

        // Decode data_json agar mudah diakses di view
        // Hasilnya berupa array, bukan string JSON
            $dataJson = is_array($riwayat->data_json) ? $riwayat->data_json : [];

        return view('riwayat.show', compact('riwayat', 'dataJson'));
    }

    // =========================================================
    //  DESTROY — hapus satu riwayat
    // =========================================================
    public function destroy(Riwayat $riwayat)
    {
        $judul = $riwayat->judul;
        $riwayat->delete();

        return back()->with('success', "Riwayat <strong>{$judul}</strong> berhasil dihapus.");
    }

    // =========================================================
    //  DESTROY ALL — hapus banyak riwayat sekaligus
    //  Wajib sertakan konfirmasi: ?jenis=smart atau ?periode_id=1
    //  Tidak boleh hapus semua tanpa parameter sama sekali
    // =========================================================
    public function destroyAll(Request $request)
    {
        // Keamanan: minimal harus ada satu filter
        // Mencegah penghapusan seluruh riwayat secara tidak sengaja
        if (!$request->filled('jenis') && !$request->filled('periode_id')) {
            return back()->with('error', 'Tentukan filter jenis atau periode sebelum menghapus semua riwayat.');
        }

        $query = Riwayat::query();

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('periode_id')) {
            $query->where('periode_id', $request->periode_id);
        }

        $count = $query->count();

        if ($count === 0) {
            return back()->with('error', 'Tidak ada riwayat yang sesuai filter untuk dihapus.');
        }

        $query->delete();

        return back()->with('success', "{$count} riwayat berhasil dihapus.");
    }
}