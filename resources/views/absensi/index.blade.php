@extends('layouts.app')

@section('title', 'Absensi')
@section('header_title', 'ABSENSI')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-10 relative min-h-[550px]">
        <form action="#" class="max-w-3xl">
            
            {{-- NIP --}}
            <div class="mb-6 relative group">
                <input type="text" placeholder="NIP" class="w-full pl-4 pr-10 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] placeholder-gray-400 font-medium transition-colors">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#6379F1]">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
            </div>

            {{-- Tanggal --}}
            <div class="mb-6 relative group">
                <input type="text" placeholder="Tanggal" onfocus="(this.type='date')" onblur="(this.type='text')" class="w-full pl-4 pr-10 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] placeholder-gray-400 font-bold text-gray-600 transition-colors">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#6379F1]">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
            </div>

            {{-- Clock In --}}
            <div class="mb-8 w-full sm:w-1/2">
                <input type="text" placeholder="Clock in" class="w-full pl-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-[#6379F1] placeholder-gray-400 font-bold text-gray-500">
            </div>

            {{-- Upload --}}
            <div class="mb-8">
                <label class="block text-gray-700 font-semibold mb-2 text-sm">Bukti Kehadiran</label>
                <div class="w-28 h-28 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center cursor-pointer hover:bg-gray-50 hover:border-[#6379F1] transition group">
                    <svg class="h-8 w-8 text-gray-400 group-hover:text-[#6379F1] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </div>
                <p class="text-red-500 text-[11px] mt-2 font-medium">*foto harus terlihat tanggal dan waktu</p>
            </div>

            {{-- Button --}}
            <div class="mt-8 md:absolute md:bottom-10 md:right-10 flex justify-end">
                <button type="submit" class="bg-[#6379F1] hover:bg-indigo-600 text-white font-bold py-3 px-12 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">Masuk</button>
            </div>

        </form>
    </div>
@endsection