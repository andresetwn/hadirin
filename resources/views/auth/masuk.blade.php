<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">

<div class="w-full max-w-5xl bg-white rounded-3xl shadow-lg overflow-hidden grid md:grid-cols-2">
    {{-- PANEL KIRI --}}
    <div class="relative hidden md:flex items-center justify-center bg-indigo-500 p-12 rounded-r-3xl">
        <div class="flex flex-col items-center justify-center z-10">
            <h2 class="text-3xl text-white font-bold mb-2">Hallo, Selamat Datang!</h2>
            <p class="mb-4 text-white text-sm">Belum punya akun?</p>
            <a href="{{ route('daftar') }}"
               class="border border-white px-6 py-2 rounded-lg text-white hover:bg-white hover:text-indigo-500 transition">
                Daftar
            </a>
        </div>
    </div>

    {{-- FORM MASUK --}}
    <div class="p-10 flex flex-col justify-center">
        <h2 class="text-2xl font-bold text-center mb-8">Masuk</h2>

        @if (session('success'))
            <div class="mb-5 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm font-semibold">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('masuk.proses') }}">
            @csrf

            <div class="mb-4">
                <label class="text-sm font-medium">NIP</label>
                <input type="text" name="nip" value="{{ old('nip') }}"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-6">
                <label class="text-sm font-medium">Password</label>
                <input type="password" name="kata_sandi"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <button type="submit"
                class="w-full bg-indigo-500 text-white py-2 rounded-lg hover:bg-indigo-600 transition">
                Masuk
            </button>
        </form>

        {{-- MOBILE LINK --}}
        <p class="text-center text-sm mt-6 md:hidden">
            Belum punya akun?
            <a href="{{ route('daftar') }}" class="text-indigo-500 font-semibold">Daftar</a>
        </p>
    </div>
</div>

</body>
</html>
