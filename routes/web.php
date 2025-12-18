<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/masuk', function () {
    return view('auth.masuk');
});

Route::get('/daftar', function () {
    return view('auth.daftar');
});

Route::get('/beranda', function () {
    return view('beranda.index');
});

Route::get('/absensi', function () {
    return view('absensi.index');
});

Route::get('/cuti', function () {
    return view('cuti.index');
});

Route::get('/riwayat', function () {
    return view('riwayat.index');
});

