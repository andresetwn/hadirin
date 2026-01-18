<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\MasukController;
use App\Http\Controllers\Auth\DaftarController;
use App\Http\Controllers\Karyawan\AbsensiController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\PermohonanCutiController;
use App\Http\Controllers\Admin\RiwayatAbsensiAdminController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\PengajuanCutiController;
use App\Http\Controllers\Admin\PengaturanController;

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
| GUEST (Belum Login)
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
| AUTH (Karyawan & Admin Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/beranda', function () {
        return view('beranda.index');
    })->name('beranda');

    Route::post('/keluar', [MasukController::class, 'keluar'])->name('keluar');

    // --- ABSENSI ---
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');
    Route::post('/absensi/masuk', [AbsensiController::class, 'masuk'])->name('absensi.masuk');
    Route::post('/absensi/pulang', [AbsensiController::class, 'pulang'])->name('absensi.pulang');

    // --- PENGAJUAN CUTI (Sisi Karyawan) ---
    Route::get('/pengajuan', [PermohonanCutiController::class, 'create'])->name('pengajuan');
    Route::post('/pengajuan', [PermohonanCutiController::class, 'store'])->name('pengajuan.store');

    // --- RIWAYAT ---
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::get('/admin', function () {
    if (Auth::check()) {
        return redirect()->route('admin.riwayat_absensi');
    }
    return redirect()->route('masuk');
});
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // 1. RIWAYAT ABSENSI
    Route::get('/riwayat-absensi', [RiwayatAbsensiAdminController::class, 'index'])->name('riwayat_absensi');
    Route::get('/riwayat-absensi/export', [RiwayatAbsensiAdminController::class, 'exportCsv'])->name('riwayat_absensi.export');
    Route::get('/riwayat-absensi/{id}/detail', [RiwayatAbsensiAdminController::class, 'show'])->name('riwayat_absensi.show');
    Route::put('/riwayat-absensi/{id}', [RiwayatAbsensiAdminController::class, 'update'])->name('riwayat_absensi.update');
    Route::delete('/riwayat-absensi/{id}', [RiwayatAbsensiAdminController::class, 'destroy'])->name('riwayat_absensi.destroy');
    // 2. MANAJEMEN KARYAWAN
    Route::resource('karyawan', KaryawanController::class)->except(['show']);

    // 3. PERSETUJUAN CUTI
    Route::get('/pengajuan', [PengajuanCutiController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/{id}', [PengajuanCutiController::class, 'show'])->name('pengajuan.show');
    Route::put('/pengajuan/{id}', [PengajuanCutiController::class, 'updateStatus'])->name('pengajuan.update');

    // --- PENGATURAN  ---
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan/profil', [PengaturanController::class, 'updateProfile'])->name('pengaturan.update_profile');
    Route::put('/pengaturan/password', [PengaturanController::class, 'updatePassword'])->name('pengaturan.update_password');
});
