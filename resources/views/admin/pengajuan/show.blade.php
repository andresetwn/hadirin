@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <p class="text-sm text-gray-500 mb-1">Admin > Pengajuan > Detail Pengajuan Cuti</p>
    <h1 class="text-2xl font-bold text-gray-800">Detail Pengajuan Cuti</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
    
    {{-- BAGIAN 1: INFORMASI KARYAWAN --}}
    <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Karyawan</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
        <div>
            <span class="block text-xs text-gray-500 mb-1">Nama Karyawan</span>
            <span class="block font-bold text-gray-900 text-base">{{ $cuti->pengguna->nama_lengkap }}</span>
        </div>
        <div>
            <span class="block text-xs text-gray-500 mb-1">NIP</span>
            <span class="block font-bold text-gray-900 text-base">{{ $cuti->pengguna->nip }}</span>
        </div>
        <div>
            <span class="block text-xs text-gray-500 mb-1">Departemen</span>
            <span class="block font-bold text-gray-900 text-base">{{ $cuti->pengguna->departemen->nama_departemen ?? '-' }}</span>
        </div>
        <div>
            <span class="block text-xs text-gray-500 mb-1">Jabatan</span>
            <span class="block font-bold text-gray-900 text-base">{{ $cuti->pengguna->jabatan->nama_jabatan ?? '-' }}</span>
        </div>
    </div>

    <hr class="border-gray-100 mb-8">

    {{-- BAGIAN 2: INFORMASI CUTI --}}
    <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Cuti</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
        <div>
            <span class="block text-xs text-gray-500 mb-1">Jenis Cuti</span>
            <span class="block font-bold text-gray-900 text-base">{{ $cuti->jenis_cuti->nama_cuti ?? '-' }}</span>
        </div>
        <div>
            <span class="block text-xs text-gray-500 mb-1">Durasi Cuti</span>
            <span class="block font-bold text-gray-900 text-base">{{ $cuti->jumlah_hari }} Hari</span>
        </div>
        <div>
            <span class="block text-xs text-gray-500 mb-1">Tanggal Mulai</span>
            <span class="block font-bold text-gray-900 text-base">{{ $cuti->tanggal_mulai->translatedFormat('d F Y') }}</span>
        </div>
        <div>
            <span class="block text-xs text-gray-500 mb-1">Tanggal Selesai</span>
            <span class="block font-bold text-gray-900 text-base">{{ $cuti->tanggal_selesai->translatedFormat('d F Y') }}</span>
        </div>
    </div>
    
    {{-- Alasan --}}
    <div class="mb-8">
        <span class="block text-xs text-gray-500 mb-1">Alasan Cuti</span>
        <p class="text-gray-700 text-sm leading-relaxed">
            {{ $cuti->alasan }}
        </p>
    </div>

    {{-- BAGIAN 3: LAMPIRAN --}}
    <div class="mb-8">
        <span class="block text-lg font-bold text-gray-900 mb-3">Lampiran</span>
        @if($cuti->lampiran_file)
            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg max-w-2xl bg-gray-50">
                <div class="flex items-center gap-4">
                    {{-- Icon File Image --}}
                    <div class="bg-[#6379F1] p-2 rounded text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800 truncate w-64">{{ basename($cuti->lampiran_file) }}</p>
                        <p class="text-xs text-gray-500">Klik download untuk melihat</p>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    {{-- Tombol Lihat/Download --}}
                    <a href="{{ asset('storage/' . $cuti->lampiran_file) }}" target="_blank" class="text-gray-500 hover:text-gray-800 transition p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </a>
                    <a href="{{ asset('storage/' . $cuti->lampiran_file) }}" download class="text-gray-500 hover:text-gray-800 transition p-2">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>
                </div>
            </div>
        @else
            <p class="text-sm text-gray-400 italic">Tidak ada lampiran yang disertakan.</p>
        @endif
    </div>

    <hr class="border-gray-100 mb-8">

    {{-- BAGIAN 4: STATUS & AKSI --}}
    <div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Status Pengajuan</h3>
        
        <div class="flex justify-between items-end">
            <div>
                @if($cuti->status_pengajuan == 'menunggu')
                    <span class="block font-bold text-orange-500 text-xl mb-1">Menunggu Persetujuan</span>
                @elseif($cuti->status_pengajuan == 'disetujui')
                    <span class="block font-bold text-emerald-600 text-xl mb-1">Disetujui</span>
                    <p class="text-xs text-gray-500">Oleh Admin pada {{ $cuti->disetujui_pada ? $cuti->disetujui_pada->translatedFormat('d F Y H:i') : '-' }}</p>
                @else
                    <span class="block font-bold text-red-600 text-xl mb-1">Ditolak</span>
                    @if($cuti->catatan_admin)
                        <p class="text-sm text-red-500 mt-1">Alasan: {{ $cuti->catatan_admin }}</p>
                    @endif
                @endif
                
                <p class="text-xs text-gray-400 mt-1">Diajukan Pada {{ $cuti->dibuat_pada->translatedFormat('d F Y') }}</p>
            </div>

            {{-- Tombol Aksi (Hanya muncul jika status masih menunggu) --}}
            @if($cuti->status_pengajuan == 'menunggu')
                <div class="flex gap-3">
                    {{-- Setujui --}}
                    <form action="{{ route('admin.pengajuan.update', $cuti->id) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="disetujui">
                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Setujui
                        </button>
                    </form>

                    {{-- Tolak --}}
                    <form action="{{ route('admin.pengajuan.update', $cuti->id) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="ditolak">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Tolak
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection