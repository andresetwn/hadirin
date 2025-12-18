@extends('layouts.app')

@section('title', 'Riwayat Absensi')
@section('header_title', 'RIWAYAT')

@section('content')
    {{-- SECTION FILTER --}}
        <div class="flex flex-col md:flex-row gap-4 mb-8">
            
            {{-- 1. Filter Bulan (Dropdown) --}}
            <div class="relative w-full md:w-1/3 group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-hover:text-[#6379F1]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>

                <select class="appearance-none w-full pl-10 pr-10 py-2.5 rounded-lg border border-gray-400 text-gray-700 font-bold focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] bg-white cursor-pointer transition-colors hover:border-gray-500">
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08" selected>Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
                
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            {{-- 2. Filter Tahun (Dropdown) --}}
            <div class="relative w-full md:w-1/3">
                <select class="appearance-none w-full border border-gray-400 rounded-lg py-2.5 px-4 text-gray-700 font-medium focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] bg-white cursor-pointer transition-colors hover:border-gray-500">
                    <option>2023</option>
                    <option>2024</option>
                    <option>2025</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            {{-- 3. Filter Lainnya (Search) --}}
            <div class="w-full md:w-1/3">
                <input type="text" placeholder="Cari..." class="w-full border border-gray-400 rounded-lg py-2.5 px-4 focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] transition-colors placeholder-gray-400">
            </div>
            
        </div>

        {{-- HEADER TABEL (Hanya Desktop) --}}
        <div class="hidden md:grid grid-cols-4 gap-4 px-4 mb-3 font-bold text-gray-800 text-sm uppercase tracking-wide text-center">
            <div class="text-left pl-2">TANGGAL</div>
            <div>MASUK</div>
            <div>PULANG</div>
            <div>KETERANGAN</div>
        </div>

        {{-- LIST DATA RIWAYAT --}}
        <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
            
            {{-- ITEM 1: HADIR --}}
            <div class="border border-gray-400 rounded-lg p-4 grid grid-cols-1 md:grid-cols-4 items-center gap-2 md:gap-4 text-center hover:bg-gray-50 transition shadow-sm">
                <div class="md:text-left font-bold text-gray-700 pl-2">01-10-2023</div>
                
                <div class="flex justify-between md:block px-4 md:px-0">
                    <span class="md:hidden text-gray-400 text-xs">Masuk:</span>
                    <span class="font-bold text-gray-800">08.00</span>
                </div>
                
                <div class="flex justify-between md:block px-4 md:px-0">
                    <span class="md:hidden text-gray-400 text-xs">Pulang:</span>
                    <span class="font-bold text-gray-800">17.00</span>
                </div>
                
                <div class="font-bold text-gray-800">HADIR</div>
            </div>

            {{-- ITEM 2: TIDAK HADIR --}}
            <div class="border border-gray-400 rounded-lg p-4 grid grid-cols-1 md:grid-cols-4 items-center gap-2 md:gap-4 text-center hover:bg-gray-50 transition shadow-sm">
                <div class="md:text-left font-bold text-gray-700 pl-2">02-10-2023</div>
                
                <div class="flex justify-between md:block px-4 md:px-0">
                    <span class="md:hidden text-gray-400 text-xs">Masuk:</span>
                    <span class="font-bold text-gray-800">00.00</span>
                </div>
                
                <div class="flex justify-between md:block px-4 md:px-0">
                    <span class="md:hidden text-gray-400 text-xs">Pulang:</span>
                    <span class="font-bold text-gray-800">00.00</span>
                </div>
                
                <div class="font-bold text-gray-800">TIDAK HADIR</div>
            </div>

            {{-- ITEM 3: CUTI --}}
            <div class="border border-gray-400 rounded-lg p-4 grid grid-cols-1 md:grid-cols-4 items-center gap-2 md:gap-4 text-center hover:bg-gray-50 transition shadow-sm">
                <div class="md:text-left font-bold text-gray-700 pl-2">03-10-2023</div>
                
                <div class="flex justify-between md:block px-4 md:px-0">
                    <span class="md:hidden text-gray-400 text-xs">Masuk:</span>
                    <span class="font-bold text-gray-800">00.00</span>
                </div>
                
                <div class="flex justify-between md:block px-4 md:px-0">
                    <span class="md:hidden text-gray-400 text-xs">Pulang:</span>
                    <span class="font-bold text-gray-800">00.00</span>
                </div>
                
                <div class="font-bold text-gray-800">CUTI</div>
            </div>

            {{-- ITEM 4: HADIR --}}
            <div class="border border-gray-400 rounded-lg p-4 grid grid-cols-1 md:grid-cols-4 items-center gap-2 md:gap-4 text-center hover:bg-gray-50 transition shadow-sm">
                <div class="md:text-left font-bold text-gray-700 pl-2">03-10-2023</div>
                
                <div class="flex justify-between md:block px-4 md:px-0">
                    <span class="md:hidden text-gray-400 text-xs">Masuk:</span>
                    <span class="font-bold text-gray-800">08.00</span>
                </div>
                
                <div class="flex justify-between md:block px-4 md:px-0">
                    <span class="md:hidden text-gray-400 text-xs">Pulang:</span>
                    <span class="font-bold text-gray-800">17.00</span>
                </div>
                
                <div class="font-bold text-gray-800">HADIR</div>
            </div>

        </div>

    </div>
@endsection