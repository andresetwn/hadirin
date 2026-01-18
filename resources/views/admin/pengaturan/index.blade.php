@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pengaturan</h1>
        <p class="text-sm text-gray-500">Admin > Pengaturan</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI (Profil) --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                
                {{-- Avatar Icon --}}
                <div class="inline-block p-1 rounded-full border-2 border-dashed border-gray-300 mb-3">
                    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-3xl">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>

                <h2 class="text-lg font-bold text-gray-800">
                    {{ $user->nama_lengkap }}
                </h2>
                <p class="text-xs text-gray-500 mb-6">Admin Access</p>

                {{-- Form Update Profil --}}
                <form action="{{ route('admin.pengaturan.update_profile') }}" method="POST" class="text-left space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="text-xs font-bold text-gray-500">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" 
                            class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#6379F1] outline-none transition focus:border-[#6379F1]" />
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-500">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                            class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#6379F1] outline-none transition focus:border-[#6379F1]" />
                    </div>

                    <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white text-sm font-bold py-2.5 rounded-lg transition shadow-sm mt-2">
                        Simpan Profil
                    </button>
                </form>
            </div>
        </div>

        {{-- KOLOM KANAN (Keamanan / Ganti Password) --}}
        <div class="col-span-1 lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#6379F1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Keamanan
                </h3>

                {{-- Form Ganti Password --}}
                <form action="{{ route('admin.pengaturan.update_password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password Saat Ini</label>
                            <input type="password" name="password_lama" placeholder="••••••••" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-[#6379F1] outline-none transition focus:border-[#6379F1]" />
                            @error('password_lama')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                            <input type="password" name="password_baru" placeholder="Min. 6 Karakter" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-[#6379F1] outline-none transition focus:border-[#6379F1]" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ulangi Password Baru</label>
                        <input type="password" name="password_baru_confirmation" placeholder="Ulangi password baru" required
                            class="w-full md:w-1/2 border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-[#6379F1] outline-none transition focus:border-[#6379F1]" />
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-50">
                        <button type="reset" class="px-6 py-2.5 border border-gray-300 text-gray-600 font-bold rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-[#6379F1] text-white font-bold rounded-lg hover:bg-indigo-600 shadow-md transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
@endsection