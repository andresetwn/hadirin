@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Akun Karyawan</h1>
    <p class="text-sm text-gray-500">Admin > Karyawan > Edit Akun Karyawan</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative">
    
    {{-- Header Button Kanan Atas --}}
    <div class="absolute top-6 right-6 flex gap-2">
        <a href="{{ route('admin.karyawan.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold text-sm">
            ← Kembali
        </a>
        <button class="px-4 py-2 bg-[#6379F1] text-white rounded-lg font-semibold text-sm flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg> 
            Edit
        </button>
        <form action="{{ route('admin.karyawan.destroy', $karyawan->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Hapus
            </button>
        </form>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST" class="mt-8 border border-gray-300 rounded-lg p-6">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">NIP</label>
            <input type="text" name="nip" value="{{ old('nip', $karyawan->nip) }}" 
                class="w-full md:w-1/3 border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#6379F1] outline-none">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $karyawan->nama_lengkap) }}" 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#6379F1] outline-none">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $karyawan->email) }}" 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#6379F1] outline-none">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-[#6379F1] outline-none">
                <option value="L" {{ $karyawan->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $karyawan->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan</label>
                <select name="id_jabatan" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-[#6379F1] outline-none">
                    @foreach($jabatan as $j)
                        <option value="{{ $j->id }}" {{ $karyawan->id_jabatan == $j->id ? 'selected' : '' }}>{{ $j->nama_jabatan }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Departemen</label>
                <select name="id_departemen" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-[#6379F1] outline-none">
                    @foreach($departemen as $d)
                        <option value="{{ $d->id }}" {{ $karyawan->id_departemen == $d->id ? 'selected' : '' }}>{{ $d->nama_departemen }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Opsi Ganti Password --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Password Baru <span class="text-xs text-gray-400 font-normal">(Kosongkan jika tidak ingin mengubah)</span></label>
            <input type="password" name="kata_sandi" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#6379F1] outline-none">
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-6 rounded-lg transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection