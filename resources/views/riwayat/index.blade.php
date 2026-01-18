{{-- resources/views/riwayat/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Absensi')
@section('header_title', 'RIWAYAT')

@section('content')

<form method="GET" action="{{ route('riwayat') }}" class="flex flex-col md:flex-row gap-4 mb-8">

    {{-- 1. Filter Bulan --}}
    <div class="relative w-full md:w-1/3 group">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-[#6379F1]">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>

        @php
            $bulanList = [
                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
            ];
        @endphp

        <select name="bulan" class="appearance-none w-full pl-10 pr-10 py-2.5 rounded-lg border border-gray-400 text-gray-700 font-bold focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] bg-white cursor-pointer transition-colors hover:border-gray-500">
            @foreach ($bulanList as $k => $v)
                <option value="{{ $k }}" {{ $bulan == $k ? 'selected' : '' }}>{{ $v }}</option>
            @endforeach
        </select>

        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    {{-- 2. Filter Tahun --}}
    <div class="relative w-full md:w-1/3">
        <select name="tahun" class="appearance-none w-full border border-gray-400 rounded-lg py-2.5 px-4 text-gray-700 font-medium focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] bg-white cursor-pointer transition-colors hover:border-gray-500">
            @for ($y = now()->year - 2; $y <= now()->year + 1; $y++)
                <option value="{{ $y }}" {{ (string)$tahun === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>

        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    {{-- 3. Search --}}
    <div class="w-full md:w-1/3 flex gap-2">
        <input name="q" value="{{ $q }}" type="text" placeholder="Cari HADIR, TERLAMBAT, CUTI..." class="w-full border border-gray-400 rounded-lg py-2.5 px-4 focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] transition-colors placeholder-gray-400">
        <button type="submit" class="px-4 rounded-lg bg-[#6379F1] text-white font-bold hover:bg-indigo-600 transition">
            Filter
        </button>
    </div>

</form>

{{-- HEADER TABEL (Desktop) --}}
<div class="hidden md:grid grid-cols-4 gap-4 px-4 mb-3 font-bold text-gray-800 text-sm uppercase tracking-wide text-center">
    <div class="text-left pl-2">TANGGAL</div>
    <div>MASUK</div>
    <div>PULANG</div>
    <div>KETERANGAN</div>
</div>

{{-- LIST DATA RIWAYAT --}}
<div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">

   @forelse ($dataRiwayat as $row)
        <div class="border border-gray-400 rounded-lg p-4 grid grid-cols-1 md:grid-cols-4 items-center gap-2 md:gap-4 text-center hover:bg-gray-50 transition shadow-sm">
            {{-- 1. TANGGAL --}}
            <div class="md:text-left font-bold text-gray-700 pl-2">
                {{ \Carbon\Carbon::parse($row['tanggal'])->format('d-m-Y') }}
            </div>

            {{-- 2. JAM MASUK --}}
            <div class="flex justify-between md:block px-4 md:px-0">
                <span class="md:hidden text-gray-400 text-xs">Masuk:</span>
                <span class="font-bold text-gray-800">{{ $row['masuk'] }}</span>
            </div>

            {{-- 3. JAM PULANG --}}
            <div class="flex justify-between md:block px-4 md:px-0">
                <span class="md:hidden text-gray-400 text-xs">Pulang:</span>
                <span class="font-bold text-gray-800">{{ $row['pulang'] }}</span>
            </div>

            {{-- 4. STATUS / KETERANGAN (YANG KITA MODIFIKASI) --}}
            <div class="font-bold text-gray-800 flex flex-col items-center md:items-center justify-center">
                @php
                    // Ubah status jadi huruf kecil agar mudah dicek
                    $statusLower = strtolower($row['status']);
                @endphp

                @if(str_contains($statusLower, 'ditolak'))
                    {{-- STATUS DITOLAK (MERAH) --}}
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        {{ $row['status'] }}
                    </span>
                    
                    {{-- Cek jika ada catatan (pastikan Controller mengirim data 'catatan') --}}
                    @if(isset($row['catatan']) && !empty($row['catatan']))
                        <span class="text-[10px] text-red-500 mt-1 italic leading-tight max-w-[150px]">
                            Note: {{ $row['catatan'] }}
                        </span>
                    @endif

                @elseif(str_contains($statusLower, 'disetujui'))
                    {{-- STATUS DISETUJUI (HIJAU) --}}
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        {{ $row['status'] }}
                    </span>

                @elseif(str_contains($statusLower, 'menunggu'))
                    {{-- STATUS MENUNGGU (KUNING) --}}
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        {{ $row['status'] }}
                    </span>

                @else
                    {{-- STATUS BIASA (HADIR/TERLAMBAT) --}}
                    {{ $row['status'] }}
                @endif
            </div>
        </div>
    @empty
        <div class="border border-gray-300 rounded-lg p-6 text-center text-gray-500 font-bold">
            Tidak ada data untuk filter yang dipilih.
        </div>
    @endforelse

</div>

@endsection
