@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <p class="text-sm text-gray-500 mb-1">Admin > Pengajuan</p>
    <h1 class="text-2xl font-bold text-gray-800">Persetujuan Pengajuan Cuti</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Search Bar --}}
    <div class="p-5 border-b border-gray-100">
        <form action="{{ route('admin.pengajuan.index') }}" method="GET">
            <div class="relative max-w-sm">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="q" value="{{ request('q') }}" 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6379F1]" 
                    placeholder="Cari NIP atau Nama">
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#F1F5F9] text-gray-600 font-bold text-sm">
                    <th class="px-6 py-4">Nama Karyawan</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Alasan Cuti</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse($pengajuan as $item)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    {{-- Kolom Nama --}}
                    <td class="px-6 py-4 align-top">
                        <div class="font-bold text-gray-900">{{ $item->pengguna->nama_lengkap }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">NIP. {{ $item->pengguna->nip }}</div>
                    </td>
                    
                    {{-- Kolom Tanggal --}}
                    <td class="px-6 py-4 align-top">
                        <div class="flex flex-col text-xs font-medium text-gray-700">
                            <span>{{ $item->tanggal_mulai->translatedFormat('j M Y') }}</span>
                            <span class="text-gray-400 text-[10px] my-1">- s/d -</span>
                            <span>{{ $item->tanggal_selesai->translatedFormat('j M Y') }}</span>
                        </div>
                    </td>

                    {{-- Kolom Alasan --}}
                    <td class="px-6 py-4 align-top">
                        <div class="font-bold text-gray-800 text-xs mb-1 bg-gray-100 inline-block px-2 py-0.5 rounded">
                            {{ $item->jenis_cuti->nama_cuti ?? 'Cuti Lain' }}
                        </div>
                        <p class="text-gray-600 leading-snug">{{ Str::limit($item->alasan, 50) }}</p>
                    </td>

                    {{-- Kolom Aksi --}}
                    <td class="px-6 py-4 text-center align-top">
                        <div class="flex justify-center items-center gap-2">
                            <a href="{{ route('admin.pengajuan.show', $item->id) }}" class="flex items-center gap-1 bg-[#6379F1] hover:bg-indigo-600 text-white px-3 py-1.5 rounded-md text-xs font-bold transition">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Detail
                            </a>

                            @if($item->status_pengajuan === 'menunggu')
                                {{-- Tombol Setujui --}}
                                <form action="{{ route('admin.pengajuan.update', $item->id) }}" method="POST" onsubmit="return confirm('Setujui pengajuan ini?')">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="disetujui">
                                    <button type="submit" class="flex items-center gap-1 bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5 rounded-md text-xs font-bold transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Setujui
                                    </button>
                                </form>

                                {{-- Tombol Tolak --}}
                                <form action="{{ route('admin.pengajuan.update', $item->id) }}" method="POST" onsubmit="return confirm('Tolak pengajuan ini?')">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md text-xs font-bold transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Tolak
                                    </button>
                                </form>
                            @else
                                {{-- Badge Status --}}
                                <span class="px-3 py-1 rounded-full text-xs font-bold border
                                    {{ $item->status_pengajuan == 'disetujui' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-red-50 text-red-600 border-red-200' }}">
                                    {{ ucfirst($item->status_pengajuan) }}
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 italic">Belum ada data pengajuan cuti.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-5 border-t border-gray-100">
        {{ $pengajuan->appends(request()->query())->links() }}
    </div>
</div>
@endsection