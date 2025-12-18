<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Absensi')</title>
    
    {{-- CSS & Scripts --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
    
    {{-- Script Toggle Sidebar Mobile --}}
    <script>
        function toggleSidebar() {
            document.getElementById('mobile-sidebar').classList.toggle('hidden');
        }
    </script>
</head>

<body class="bg-gray-100 font-sans antialiased text-gray-800">

    <div class="flex min-h-screen relative">

        {{-- 1. SIDEBAR DESKTOP --}}
        <aside class="hidden lg:block w-fit shrink-0">
            @include('layouts.sidebar')
        </aside>

        {{-- 2. SIDEBAR MOBILE (Overlay) --}}
        <div id="mobile-sidebar" class="hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50 lg:hidden" onclick="toggleSidebar()">
            <div class="h-full w-fit" onclick="event.stopPropagation()">
                @include('layouts.sidebar')
            </div>
        </div>

        {{-- 3. KONTEN UTAMA --}}
        <main class="flex-1 flex flex-col h-screen overflow-y-auto">
            
            {{-- HEADER (Dibuat sebagai komponen include atau langsung di sini jika sama terus) --}}
            <div class="bg-white shadow-sm border-b border-gray-100 px-6 py-4 mb-6 sticky top-0 z-30">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        {{-- Toggle Button Mobile --}}
                        <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-500 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                        {{-- Judul Halaman Dinamis --}}
                        <h1 class="font-bold text-xl tracking-wide text-gray-800">@yield('header_title', 'DASHBOARD')</h1>
                    </div>
                    
                    {{-- User Profile --}}
                    <div class="flex items-center gap-3 text-sm">
                        <div class="text-right hidden sm:block">
                            <div class="font-bold text-gray-900">Gita Hasna</div>
                            <div class="text-xs text-gray-500">Manager</div>
                        </div>
                        <div class="w-10 h-10 bg-indigo-50 border border-indigo-100 rounded-full flex items-center justify-center text-[#6379F1] font-bold shadow-sm">GH</div>
                    </div>
                </div>
            </div>

            {{-- AREA KONTEN BERUBAH-UBAH --}}
            <div class="px-4 sm:px-8 pb-8">
                @yield('content')
            </div>

        </main>
    </div>

</body>
</html>