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
        <div class="flex flex-col items-center justify-centerz-10">
            <h2 class="text-3xl text-white font-bold mb-2">Hallo, Selamat Datang!</h2>
            <p class="mb-4 text-white text-sm">Belum punya akun?</p>
            <a href="/daftar"
               class="border border-white px-6 py-2 rounded-lg text-white hover:bg-white hover:text-indigo-500 transition">
                Daftar
            </a>
        </div>
    </div>

    {{-- FORM LOGIN --}}
    <div class="p-10 flex flex-col justify-center">
        <h2 class="text-2xl font-bold text-center mb-8">Masuk</h2>

        <form>
            <div class="mb-4">
                <label class="text-sm font-medium">NIP</label>
                <input type="text"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-6">
                <label class="text-sm font-medium">Password</label>
                <input type="password"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <button
                class="w-full bg-indigo-500 text-white py-2 rounded-lg hover:bg-indigo-600 transition">
                Masuk
            </button>
        </form>

        {{-- MOBILE LINK --}}
        <p class="text-center text-sm mt-6 md:hidden">
            Belum punya akun?
            <a href="/daftar" class="text-indigo-500 font-semibold">Daftar</a>
        </p>
    </div>

</div>

</body>
</html>
