<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\AhpController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\NilaiSiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SmartController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard (semua role)
    Route::get('/',         [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard',[DashboardController::class, 'index']);

    // ──────────────────────────────────────────
    // ADMIN ONLY
    // ──────────────────────────────────────────
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users',                 [UserController::class, 'index'])       ->name('users');
        Route::post('/users',                [UserController::class, 'store'])       ->name('users.store');
        Route::put('/users/{user}',          [UserController::class, 'update'])      ->name('users.update');
        Route::delete('/users/{user}',       [UserController::class, 'destroy'])     ->name('users.destroy');
        Route::patch('/users/{user}/toggle', [UserController::class, 'toggleActive'])->name('users.toggle');
    });

    // ──────────────────────────────────────────
    // Periode — Admin only
    // ──────────────────────────────────────────
    Route::middleware('role:admin')->prefix('periode')->name('periode.')->group(function () {
        Route::get('/',             [PeriodeController::class, 'index'])  ->name('index');
        Route::post('/',            [PeriodeController::class, 'store'])  ->name('store');
        Route::put('/{periode}',    [PeriodeController::class, 'update']) ->name('update');
        Route::delete('/{periode}', [PeriodeController::class, 'destroy'])->name('destroy');
    });

    // ──────────────────────────────────────────
    // Kriteria — Admin only
    // ──────────────────────────────────────────
    Route::middleware('role:admin')
        ->resource('kriteria', KriteriaController::class, [
            'parameters' => ['kriteria' => 'kriteria'],
        ])
        ->only(['index', 'store', 'update', 'destroy', 'show']);

    // ──────────────────────────────────────────
    // Siswa
    // ──────────────────────────────────────────

    // Show — semua role (tombol 👁)
    Route::middleware('role:admin,wali_kelas,kepala_sekolah')
        ->get('/siswa/{siswa}', [SiswaController::class, 'show'])
        ->whereNumber('siswa')
        ->name('siswa.show');

    Route::middleware('role:admin')->prefix('siswa')->name('siswa.')->group(function () {
        // ─── List & Create ───────────────────────────────────────────────────
        Route::get('/',       [SiswaController::class, 'index']) ->name('index');
        Route::get('/create', [SiswaController::class, 'create'])->name('create');
        Route::post('/',      [SiswaController::class, 'store']) ->name('store');

        // ─── BULK — HARUS di atas /{siswa} agar tidak tertangkap wildcard ───
        // FIX: Route ini dipindah ke atas sebelum /{siswa}
        Route::delete('/hapus-bulk', [SiswaController::class, 'destroyBulk'])->name('destroyBulk');

        // ─── Single siswa ────────────────────────────────────────────────────
        Route::get('/{siswa}/edit',        [SiswaController::class, 'edit'])       ->name('edit');
        Route::put('/{siswa}',             [SiswaController::class, 'update'])     ->name('update');
        Route::delete('/{siswa}',          [SiswaController::class, 'destroy'])    ->name('destroy');
        Route::post('/{id}/hitung-simpan', [SiswaController::class, 'hitungSimpan'])->name('hitungSimpan');
    });

    // ──────────────────────────────────────────
    // Nilai — Admin & Wali Kelas
    // ──────────────────────────────────────────
    Route::middleware('role:admin,wali_kelas')->prefix('nilai')->name('nilai.')->group(function () {
        Route::get('/',              [NilaiSiswaController::class, 'index'])  ->name('index');
        Route::get('/{siswa}/input', [NilaiSiswaController::class, 'create']) ->name('create');
        Route::post('/{siswa}',      [NilaiSiswaController::class, 'store'])  ->name('store');
        Route::get('/{siswa}/edit',  [NilaiSiswaController::class, 'edit'])   ->name('edit');
        Route::put('/{siswa}',       [NilaiSiswaController::class, 'update']) ->name('update');
        Route::get('/{siswa}/show',  [NilaiSiswaController::class, 'show'])   ->name('show');
    });

    // ──────────────────────────────────────────
    // AHP — Admin only
    // ──────────────────────────────────────────
    Route::middleware('role:admin')->prefix('ahp')->name('ahp.')->group(function () {
        Route::get('/',        [AhpController::class, 'index']) ->name('index');
        Route::get('/matriks', [AhpController::class, 'index']) ->name('matriks');
        Route::post('/hitung', [AhpController::class, 'hitung'])->name('hitung');
    });

    // ──────────────────────────────────────────
    // SMART — Admin, Wali Kelas & Kepala Sekolah
    // ──────────────────────────────────────────
    Route::middleware('role:admin,wali_kelas,kepala_sekolah')->group(function () {
        Route::get('/smart',        [SmartController::class, 'index'])        ->name('smart.index');
        Route::post('/smart/hitung',[SmartController::class, 'hitungDanSimpan'])->name('smart.hitung');
    });

    // ──────────────────────────────────────────
    // Riwayat — semua role (delete admin only)
    // ──────────────────────────────────────────
    Route::middleware('role:admin,wali_kelas,kepala_sekolah')
        ->prefix('riwayat')->name('riwayat.')->group(function () {
            Route::get('/',          [RiwayatController::class, 'index'])->name('index');
            Route::get('/{riwayat}', [RiwayatController::class, 'show']) ->name('show');
        });

    Route::middleware('role:admin')
        ->prefix('riwayat')->name('riwayat.')->group(function () {
            Route::delete('/{riwayat}', [RiwayatController::class, 'destroy'])   ->name('destroy');
            Route::delete('/',          [RiwayatController::class, 'destroyAll'])->name('destroyAll');
        });

});