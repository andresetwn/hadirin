@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.app')

@section('title', 'Beranda')
@section('header_title', 'HOME')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-10 min-h-[500px]">

        {{-- Greeting --}}
        <div class="mb-10">
            <h2 class="text-xl font-bold text-gray-400">Hallo,</h2>

            <h3 class="text-3xl sm:text-4xl font-extrabold text-gray-800 mt-1">
                {{ Auth::user()->nama_lengkap }}
            </h3>

            <div class="flex items-center gap-2 mt-3 text-[#6379F1] font-medium bg-indigo-50 w-fit px-4 py-1.5 rounded-full text-sm">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>

                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
            </div>
        </div>

        {{-- Grid Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Card 1: Absen --}}
            <div class="bg-indigo-500 text-white rounded-2xl p-6 flex flex-col justify-between gap-6 shadow-lg relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 opacity-20 transform group-hover:scale-110 transition duration-300">
                    <svg class="h-32 w-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.131A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.2-2.858.567-4.181m-3.23 12.492c-.97 1.493 1.2 3.508 5.117 3.508.636 0 1.262-.068 1.864-.196" />
                    </svg>
                </div>

                <div class="relative z-10">
                    <p class="font-medium text-indigo-200 text-sm">Status Kehadiran</p>
                    <p class="font-bold text-xl mt-1">Siap Bekerja Hari Ini?</p>
                </div>

                <a href="/absensi"
                   class="relative z-10 bg-white text-[#6379F1] font-bold py-3 px-4 rounded-xl w-full text-center hover:bg-indigo-50 transition shadow-md">
                    ABSEN SEKARANG
                </a>
            </div>

            {{-- Card 2: Cuti --}}
            <div class="bg-indigo-500 text-white rounded-2xl p-6 flex flex-col justify-between gap-6 shadow-lg relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 opacity-20 transform group-hover:scale-110 transition duration-300">
                    <svg class="h-32 w-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                </div>

                <div class="relative z-10">
                    <p class="font-medium text-indigo-100 text-sm">Pengajuan</p>
                    <p class="font-bold text-xl mt-1">Berhalangan Hadir?</p>
                </div>

                <a href="/pengajuan"
                   class="relative z-10 bg-white text-indigo-500 font-bold py-3 px-4 rounded-xl w-full text-center hover:bg-indigo-50 transition shadow-md">
                    CUTI & IZIN
                </a>
            </div>

            {{-- Card 3: Riwayat --}}
            <div class="bg-indigo-500 text-white rounded-2xl p-6 flex flex-col justify-between gap-6 shadow-lg relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 opacity-20 transform group-hover:scale-110 transition duration-300">
                    <svg class="h-32 w-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 0 0118 0z" />
                    </svg>
                </div>

                <div class="relative z-10">
                    <p class="font-medium text-indigo-100 text-sm">Log Aktivitas</p>
                    <p class="font-bold text-xl mt-1">Cek Riwayat Kehadiran?</p>
                </div>

                <a href="/riwayat"
                   class="relative z-10 bg-white text-indigo-500 font-bold py-3 px-4 rounded-xl w-full text-center hover:bg-indigo-50 transition shadow-md">
                    LIHAT RIWAYAT
                </a>
            </div>
        </div>
    </div>
@endsection
