@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Daftar Karyawan</h1>
    
    <a href="{{ route('admin.karyawan.create') }}" class="bg-[#6379F1] hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg flex items-center shadow-lg transition">
        + Tambah Karyawan
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Search Bar --}}
    <div class="p-5 border-b border-gray-100">
        <form action="{{ route('admin.karyawan.index') }}" method="GET">
            <div class="relative max-w-sm">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="q" value="{{ request('q') }}" 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6379F1]" 
                    placeholder="Cari Karyawan">
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#F1F5F9] text-gray-600 font-bold text-sm">
                    <th class="px-6 py-4">NIP</th>
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">Jabatan</th>
                    <th class="px-6 py-4">Departemen</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse($karyawan as $k)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    
                    {{-- Kolom NIP --}}
                    <td class="px-6 py-4 font-medium text-gray-500">
                        {{ $k->nip }}
                    </td>

                    {{-- KOLOM NAMA (YANG DIUPDATE) --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-900">{{ $k->nama_lengkap }}</span>
                            
                            {{-- LOGIKA: Jika Role adalah Admin --}}
                            @if($k->role === 'admin')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#6379F1]/10 text-[#6379F1] border border-[#6379F1]/20" title="Administrator">
                                    {{-- Ikon Shield Kecil --}}
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Admin
                                </span>
                            @endif
                        </div>
                    </td>

                    {{-- Jabatan --}}
                    <td class="px-6 py-4">
                        {{ $k->jabatan->nama_jabatan ?? '-' }}
                    </td>

                    {{-- Departemen --}}
                    <td class="px-6 py-4">
                        {{ $k->departemen->nama_departemen ?? '-' }}
                    </td>

                    {{-- Email --}}
                    <td class="px-6 py-4 text-gray-500">
                        {{ $k->email }}
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.karyawan.edit', $k->id) }}" class="p-1 text-blue-500 hover:text-blue-700 transition rounded hover:bg-blue-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.karyawan.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus karyawan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1 text-red-500 hover:text-red-700 transition rounded hover:bg-red-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">
                        Tidak ada data karyawan ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-4 border-t border-gray-100">
        {{ $karyawan->appends(request()->query())->links() }}
    </div>
</div>
@endsection