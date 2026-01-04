<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\MasukController;
use App\Http\Controllers\Auth\DaftarController;
use App\Http\Controllers\Karyawan\AbsensiController;
use App\Http\Controllers\PengajuanCutiController;
use App\Http\Controllers\RiwayatController;
/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('beranda');
    }
    return redirect()->route('masuk');
});

/*
|--------------------------------------------------------------------------
| GUEST (belum login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [MasukController::class, 'formMasuk'])->name('masuk');
    Route::post('/masuk', [MasukController::class, 'prosesMasuk'])->name('masuk.proses');

    Route::get('/daftar', [DaftarController::class, 'formDaftar'])->name('daftar');
    Route::post('/daftar', [DaftarController::class, 'prosesDaftar'])->name('daftar.proses');
});

/*
|--------------------------------------------------------------------------
| AUTH (sudah login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/beranda', function () {
        return view('beranda.index');
    })->name('beranda');

    Route::post('/keluar', [MasukController::class, 'keluar'])->name('keluar');

    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');
    Route::post('/absensi/masuk', [AbsensiController::class, 'masuk'])->name('absensi.masuk');
    Route::post('/absensi/pulang', [AbsensiController::class, 'pulang'])->name('absensi.pulang');

    // Pengajuan cuti (ambil jenis cuti dari DB + simpan ke DB)
    Route::middleware('auth')->group(function () {
        Route::get('/pengajuan', [PengajuanCutiController::class, 'create'])->name('pengajuan');
        Route::post('/pengajuan', [PengajuanCutiController::class, 'store'])->name('cuti.store');
    });

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
| 
*/
Route::get('/admin', function () {
    return 'Dashboard Admin';
})->middleware('auth')->name('admin');
