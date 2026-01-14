<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@yield('title', 'Admin Hadirin')</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
        />
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");
            body {
                font-family: "Poppins", sans-serif;
            }
        </style>
    </head>
    <body class="bg-[#FAFAFA] text-gray-800 font-sans antialiased">
        <div class="flex min-h-screen">
            {{-- SIDEBAR ADMIN (WHITE STYLE) --}}
            <aside
                class="w-72 bg-white border-r border-gray-200 flex flex-col fixed h-full z-10"
            >
                {{-- LOGO AREA --}}
                <div class="p-8 flex items-center gap-3">
                    <span
                        class="text-2xl font-bold text-gray-900 tracking-tight"
                        >Hadirin</span
                    >
                </div>

                {{-- NAVIGATION --}}
                <nav class="flex-1 px-6 space-y-2 mt-2">
                    {{-- MENU: RIWAYAT ABSENSI (AKTIF) --}}
                    {{-- Logika: Jika route saat ini mengandung 'riwayat_absensi', maka aktif --}}
                    <a
                        href="{{ route('admin.riwayat_absensi') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ request()->routeIs('admin.riwayat_absensi*') ? 'bg-indigo-100 text-indigo-600 shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-indigo-600' }}"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        <span class="font-semibold">Riwayat Absensi</span>
                    </a>

                    {{-- MENU: KARYAWAN --}}
                    <a
                        href="{{ route('admin.karyawan.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-indigo-600 transition-all duration-200"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                            />
                        </svg>
                        <span class="font-medium">Karyawan</span>
                    </a>

                    {{-- MENU: PENGAJUAN --}}
                    <a
                        href="{{ route('admin.pengajuan.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-indigo-600 transition-all duration-200"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            />
                        </svg>
                        <span class="font-medium">Pengajuan</span>
                    </a>

                    {{-- MENU: PENGATURAN --}}
                    <a
                        href="route('admin.pengaturan')"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-indigo-600 transition-all duration-200"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>
                        <span class="font-medium">Pengaturan</span>
                    </a>
                </nav>

                {{-- LOGOUT --}}
                <div class="p-8">
                    <form action="{{ route('keluar') }}" method="POST">
                        @csrf
                        <button
                            class="flex items-center gap-3 text-gray-500 hover:text-red-500 transition-colors duration-200 font-medium w-full"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                />
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </aside>

            {{-- KONTEN UTAMA --}}
            {{-- Margin left 72 (w-72) agar tidak tertutup sidebar yang fixed --}}
            <main class="flex-1 ml-72 p-8 md:p-12 overflow-y-auto min-h-screen">
                @yield('content')
            </main>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    </body>
</html>
