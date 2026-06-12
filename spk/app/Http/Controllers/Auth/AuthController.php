<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        // Cek apakah user aktif
        $user = \App\Models\User::where('username', $request->username)->first();

        if ($user && !$user->is_active) {
            return back()->withErrors([
                'username' => 'Akun kamu tidak aktif. Hubungi admin.',
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return match(Auth::user()->role) {
                'admin'          => redirect()->route('dashboard')->with('success', 'Selamat datang, Admin!'),
                'wali_kelas'     => redirect()->route('dashboard')->with('success', 'Selamat datang, Wali Kelas!'),
                'kepala_sekolah' => redirect()->route('dashboard')->with('success', 'Selamat datang, Kepala Sekolah!'),
                default          => redirect()->route('login'),
            };
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}