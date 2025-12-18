<aside class="w-24 bg-indigo-500 min-h-screen rounded-r-3xl flex flex-col items-center py-8 shadow-xl relative z-20">
    
    {{-- TOGGLE / MENU BUTTON --}}
    {{-- Di Mobile: Menutup sidebar --}}
    {{-- Di Desktop: Bisa difungsikan lain atau disembunyikan jika tidak perlu --}}
    <button onclick="toggleSidebar()" class="mb-10 text-white hover:bg-indigo-400 p-2 rounded-lg transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    {{-- MENU LIST --}}
    <nav class="flex flex-col items-center gap-4 text-white lg:text-sm text-xs font-medium w-full flex-1">
        
        {{-- HOME --}}
        <a href="/beranda" class="group flex flex-col items-center gap-1 opacity-70 hover:opacity-100 transition w-full py-2 border-r-4 border-transparent hover:border-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 lg:w-10 lg:h-10 group-hover:scale-110 transition duration-200">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            <span>Home</span>
        </a>

        {{-- ABSENSI --}}
        <a href="#" class="group flex flex-col items-center gap-1 opacity-70 hover:opacity-100 transition w-full py-2 border-r-4 border-transparent hover:border-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 lg:w-10 lg:h-10 group-hover:scale-110 transition duration-200">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 0 1-3.6 9.75m6.633-4.596a18.666 18.666 0 0 1-2.485 5.33" />
            </svg>
            <span>Absensi</span>
        </a>

        {{-- CUTI & IZIN --}}
        <a href="#" class="group flex flex-col items-center gap-1 opacity-70 hover:opacity-100 transition w-full py-2 border-r-4 border-transparent hover:border-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 lg:w-10 lg:h-10 group-hover:scale-110 transition duration-200">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
            </svg>
            <span class="text-center leading-tight">Cuti &<br>Izin</span>
        </a>

        {{-- RIWAYAT --}}
        <a href="#" class="group flex flex-col items-center gap-1 opacity-70 hover:opacity-100 transition w-full py-2 border-r-4 border-transparent hover:border-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 lg:w-10 lg:h-10 group-hover:scale-110 transition duration-200">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
            <span>Riwayat</span>
        </a>

    </nav>

    {{-- LOGOUT --}}
    <div class="mt-auto mb-4 w-full">
        <a href="#" class="group flex flex-col items-center gap-1 text-white lg:text-sm text-xs font-medium opacity-70 hover:opacity-100 transition cursor-pointer py-2 hover:border-white hover:text-red-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 lg:w-10 lg:h-10 group-hover:scale-110 transition duration-200">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
            </svg>
            <span>Keluar</span>
        </a>
    </div>

</aside>