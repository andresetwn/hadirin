<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controller Auth
use App\Http\Controllers\Auth\MasukController;
use App\Http\Controllers\Auth\DaftarController;

// Controller Karyawan / Umum
use App\Http\Controllers\Karyawan\AbsensiController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\PermohonanCutiController; // Controller User (Input Form)

// Controller Admin
use App\Http\Controllers\Admin\RiwayatAbsensiAdminController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\PengajuanCutiController; // Controller Admin (Approval)

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
    // Menggunakan PermohonanCutiController
    Route::get('/pengajuan', [PermohonanCutiController::class, 'create'])->name('pengajuan');
    Route::post('/pengajuan', [PermohonanCutiController::class, 'store'])->name('pengajuan.store');

    // --- RIWAYAT ---
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
});

/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/
// Redirect /admin ke halaman yang benar
Route::get('/admin', function () {
    if (Auth::check()) {
        // Pastikan user punya akses admin (bisa tambah cek role di sini jika perlu)
        return redirect()->route('admin.riwayat_absensi');
    }
    return redirect()->route('masuk');
});

// Group Route Admin
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // 1. RIWAYAT ABSENSI
    Route::get('/riwayat-absensi', [RiwayatAbsensiAdminController::class, 'index'])->name('riwayat_absensi');
    Route::get('/riwayat-absensi/export', [RiwayatAbsensiAdminController::class, 'exportCsv'])->name('riwayat_absensi.export');
    Route::get('/riwayat-absensi/{id}/detail', [RiwayatAbsensiAdminController::class, 'show'])->name('riwayat_absensi.show');
    Route::put('/riwayat-absensi/{id}', [RiwayatAbsensiAdminController::class, 'update'])->name('riwayat_absensi.update');
    Route::delete('/riwayat-absensi/{id}', [RiwayatAbsensiAdminController::class, 'destroy'])->name('riwayat_absensi.destroy');

    // 2. MANAJEMEN KARYAWAN
    Route::resource('karyawan', KaryawanController::class)->except(['show']);

    // 3. PERSETUJUAN CUTI (Sisi Admin)
    // Menggunakan PengajuanCutiController (Namespace Admin)
    Route::get('/pengajuan', [PengajuanCutiController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/{id}', [PengajuanCutiController::class, 'show'])->name('pengajuan.show');
    Route::put('/pengajuan/{id}', [PengajuanCutiController::class, 'updateStatus'])->name('pengajuan.update');
});
