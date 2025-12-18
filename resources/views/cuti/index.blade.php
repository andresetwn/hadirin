@extends('layouts.app')

@section('title', 'Pengajuan Cuti')
@section('header_title', 'Pengajuan Cuti & Izin')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-10 relative min-h-[550px]">
        
        <form action="#" class="max-w-4xl">
            
            {{-- JENIS PENGAJUAN --}}
            <div class="mb-6">
                <label class="block text-gray-500 font-bold mb-2 text-sm">Jenis Pengajuan</label>
                <div class="relative group">
                    <input type="text" placeholder="Cuti Tahunan / Izin Khusus" 
                           class="w-full pl-4 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] placeholder-gray-300 font-bold text-gray-600 transition-colors">
                </div>
            </div>

            {{-- ROW TANGGAL (GRID 2 KOLOM) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                
                {{-- TANGGAL MULAI --}}
                <div>
                    <label class="block text-gray-500 font-bold mb-2 text-sm">Tanggal Mulai</label>
                    <div class="relative group">
                        <input type="text" placeholder="Pilih Tanggal" onfocus="(this.type='date')" onblur="(this.type='text')"
                               class="w-full pl-4 pr-10 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] placeholder-gray-300 font-bold text-gray-600 transition-colors">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#6379F1]">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                    </div>
                </div>

                {{-- TANGGAL SELESAI --}}
                <div>
                    <label class="block text-gray-500 font-bold mb-2 text-sm">Tanggal Selesai</label>
                    <div class="relative group">
                        <input type="text" placeholder="Pilih Tanggal" onfocus="(this.type='date')" onblur="(this.type='text')"
                               class="w-full pl-4 pr-10 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] placeholder-gray-300 font-bold text-gray-600 transition-colors">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#6379F1]">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ALASAN / KETERANGAN --}}
            <div class="mb-6">
                <label class="block text-gray-500 font-bold mb-2 text-sm">Alasan / Keterangan</label>
                <div class="relative group">
                    <input type="text" placeholder="Deskripsikan" 
                           class="w-full pl-4 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] placeholder-gray-300 font-bold text-gray-600 transition-colors">
                </div>
            </div>

            {{-- LAMPIRAN --}}
            <div class="mb-8">
                <label class="block text-gray-500 font-bold mb-2 text-sm">Lampiran</label>
                <div class="w-28 h-24 border border-gray-400 flex items-center justify-center cursor-pointer hover:bg-gray-50 hover:border-[#6379F1] transition group">
                    <svg class="h-6 w-6 text-black group-hover:text-[#6379F1] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                </div>
            </div>

            {{-- BUTTON KIRIM --}}
            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-[#6379F1] hover:bg-indigo-600 text-white font-bold py-3 px-12 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    Kirim
                </button>
            </div>

        </form>
    </div>
@endsection