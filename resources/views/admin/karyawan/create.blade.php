@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Tambah Karyawan</h1>
    <p class="text-sm text-gray-500">Admin > Karyawan > Tambah Baru</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative">
    
    {{-- Tombol Kembali --}}
    <div class="absolute top-6 right-6">
        <a href="{{ route('admin.karyawan.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold text-sm">
            ← Kembali
        </a>
    </div>

    {{-- Form Tambah --}}
    <form action="{{ route('admin.karyawan.store') }}" method="POST" class="mt-8 border border-gray-300 rounded-lg p-6">
        @csrf 

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">NIP</label>
            <input type="text" name="nip" value="{{ old('nip') }}" required
                class="w-full md:w-1/3 border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#6379F1] outline-none" placeholder="Contoh: 10122001">
            @error('nip') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#6379F1] outline-none" placeholder="Nama Lengkap Karyawan">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#6379F1] outline-none" placeholder="email@kantor.com">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
            <input type="password" name="kata_sandi" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#6379F1] outline-none" placeholder="Minimal 6 karakter">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-[#6379F1] outline-none">
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan</label>
                <select name="id_jabatan" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-[#6379F1] outline-none">
                    @foreach($jabatan as $j)
                        <option value="{{ $j->id }}">{{ $j->nama_jabatan }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Departemen</label>
                <select name="id_departemen" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-[#6379F1] outline-none">
                    @foreach($departemen as $d)
                        <option value="{{ $d->id }}">{{ $d->nama_departemen }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-[#6379F1] hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition">
                + Simpan Karyawan
            </button>
        </div>
    </form>
</div>
@endsection