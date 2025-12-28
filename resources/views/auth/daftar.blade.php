<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">

<div class="w-full max-w-5xl bg-white rounded-3xl shadow-lg overflow-hidden grid md:grid-cols-4 gap-4">

    {{-- FORM DAFTAR --}}
    <div class="md:col-span-3 p-10 flex flex-col justify-center">
        <h2 class="text-2xl font-bold text-center mb-8">Daftar</h2>

        @if ($errors->any())
            <div class="mb-5 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm font-semibold">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('daftar.proses') }}">
            @csrf

            <div class="mb-3">
                <label class="text-sm">Nama</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                    class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="mb-3">
                <label class="text-sm">NIP</label>
                <input type="text" name="nip" value="{{ old('nip') }}"
                    class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="mb-3">
                <label class="text-sm">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="mb-3">
                <label class="text-sm">Password</label>
                <input type="password" name="kata_sandi"
                    class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="mb-3">
                <label class="text-sm">Konfirmasi Password</label>
                <input type="password" name="kata_sandi_confirmation"
                    class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Departemen & Jabatan pakai dropdown --}}
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label class="text-sm">Departemen</label>
                    <select name="id_departemen" class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Pilih Departemen</option>
                        @foreach ($departemen as $d)
                            <option value="{{ $d->id }}" {{ old('id_departemen') == $d->id ? 'selected' : '' }}>
                                {{ $d->nama_departemen }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm">Jabatan</label>
                    <select name="id_jabatan" class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Pilih Jabatan</option>
                        @foreach ($jabatan as $j)
                            <option value="{{ $j->id }}" {{ old('id_jabatan') == $j->id ? 'selected' : '' }}>
                                {{ $j->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="text-sm">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Pilih</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <button type="submit"
                class="w-full bg-indigo-500 text-white py-2 rounded-lg hover:bg-indigo-600 transition">
                Daftar
            </button>
        </form>

        {{-- MOBILE LINK --}}
        <p class="text-center text-sm mt-6 md:hidden">
            Sudah punya akun?
            <a href="{{ route('masuk') }}" class="text-indigo-500 font-semibold">Masuk</a>
        </p>
    </div>

    {{-- PANEL KANAN --}}
    <div class="relative hidden md:flex items-center justify-center bg-indigo-500 p-12 rounded-l-3xl">
        <div class="flex flex-col z-10 text-center">
            <h2 class="text-3xl text-white font-bold mb-2">Silahkan Daftar!</h2>
            <p class="mb-4 text-white text-sm">Sudah punya akun?</p>
            <a href="{{ route('masuk') }}"
               class="border text-white border-white px-6 py-2 rounded-lg hover:bg-white hover:text-indigo-500 transition">
                Masuk
            </a>
        </div>
    </div>

</div>

</body>
</html>
