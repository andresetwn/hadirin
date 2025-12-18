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

    {{-- FORM REGISTER --}}
    <div class="md:col-span-3 p-10 flex flex-col justify-center">
        <h2 class="text-2xl font-bold text-center mb-8">Daftar</h2>

        <form>
            <div class="mb-3">
                <label class="text-sm">Nama</label>
                <input type="text" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="mb-3">
                <label class="text-sm">NIP</label>
                <input type="text" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="mb-3">
                <label class="text-sm">Email</label>
                <input type="email" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="mb-3">
                <label class="text-sm">Password</label>
                <input type="password" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="grid grid-cols-2 gap-3 mb-6">
                <input type="text" placeholder="Posisi" class="px-4 py-2 border rounded-lg">
                <input type="text" placeholder="Jenis Kelamin" class="px-4 py-2 border rounded-lg">
            </div>

            <button
                class="w-full bg-indigo-500 text-white py-2 rounded-lg hover:bg-indigo-600 transition">
                Daftar
            </button>
        </form>
         {{-- MOBILE LINK --}}
        <p class="text-center text-sm mt-6 md:hidden">
            Sudah punya akun?
            <a href="/masuk" class="text-indigo-500 font-semibold">Masuk</a>
        </p>
    </div>

    {{-- PANEL KANAN --}}
    <div class="relative hidden md:flex items-center justify-center bg-indigo-500 p-12 rounded-l-3xl">
        <div class="flex flex-col z-10 text-center">
            <h2 class="text-3xl text-white font-bold mb-2">Silahkan Daftar!</h2>
            <p class="mb-4 text-white text-sm">Sudah punya akun?</p>
            <a href="/masuk"
               class="border text-white border-white px-6 py-2 rounded-lg hover:bg-white hover:text-indigo-500 transition">
                Masuk
            </a>
        </div>
    </div>

</div>

</body>
</html>
