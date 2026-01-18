@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <p class="text-sm text-gray-500 mb-1">Admin > Pengajuan</p>
        <h1 class="text-2xl font-bold text-gray-800">
            Persetujuan Pengajuan Cuti
        </h1>
    </div>

    <div
        class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"
    >
        {{-- 1. SEARCH BAR --}}
        <div class="p-5 border-b border-gray-100">
            <form action="{{ route('admin.pengajuan.index') }}" method="GET">
                <div class="relative max-w-sm">
                    <span
                        class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            ></path>
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6379F1] transition"
                        placeholder="Cari NIP atau Nama..."
                    />
                </div>
            </form>
        </div>

        {{-- 2. TABEL DATA --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F1F5F9] text-gray-600 font-bold text-sm">
                        <th class="px-6 py-4">Nama Karyawan</th>
                        <th class="px-6 py-4">Tanggal Cuti</th>
                        <th class="px-6 py-4">Jenis & Alasan</th>
                        <th class="px-6 py-4 text-center">Status / Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse ($pengajuan as $item)
                        <tr
                            class="border-b border-gray-100 hover:bg-gray-50 transition"
                        >
                            {{-- Nama & NIP --}}
                            <td class="px-6 py-4 align-top">
                                <div class="font-bold text-gray-900">
                                    {{ $item->pengguna->nama_lengkap }}
                                </div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    NIP. {{ $item->pengguna->nip }}
                                </div>
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-6 py-4 align-top">
                                <div
                                    class="flex flex-col text-xs font-medium text-gray-700"
                                >
                                    <span>
                                        {{ $item->tanggal_mulai->translatedFormat('d M Y') }}
                                    </span>
                                    <span
                                        class="text-gray-400 text-[10px] my-0.5"
                                    >
                                        s/d
                                    </span>
                                    <span>
                                        {{ $item->tanggal_selesai->translatedFormat('d M Y') }}
                                    </span>
                                    <span
                                        class="mt-1 text-xs text-indigo-600 font-bold"
                                    >
                                        ({{ $item->jumlah_hari }} Hari)
                                    </span>
                                </div>
                            </td>

                            {{-- Jenis & Alasan --}}
                            <td class="px-6 py-4 align-top">
                                <div
                                    class="font-bold text-gray-800 text-xs mb-1 bg-gray-100 inline-block px-2 py-0.5 rounded border border-gray-200"
                                >
                                    {{ $item->jenis_cuti->nama_cuti ?? 'Cuti Lain' }}
                                </div>
                                <p class="text-gray-600 leading-snug italic">
                                    "{{ Str::limit($item->alasan, 50) }}"
                                </p>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-center align-top">
                                <div class="flex flex-col items-center gap-2">
                                    {{-- Tombol Detail --}}
                                    <a
                                        href="{{ route('admin.pengajuan.show', $item->id) }}"
                                        class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold hover:underline mb-1"
                                    >
                                        Lihat Detail
                                    </a>

                                    @if ($item->status_pengajuan === 'menunggu')
                                        <div class="flex gap-2">
                                            {{-- Tombol Setujui (Langsung Submit) --}}
                                            <form
                                                action="{{ route('admin.pengajuan.update', $item->id) }}"
                                                method="POST"
                                                onsubmit="
                                                    return confirm(
                                                        'Apakah Anda yakin ingin menyetujui pengajuan ini?'
                                                    );
                                                "
                                            >
                                                @csrf
                                                @method('PUT')
                                                <input
                                                    type="hidden"
                                                    name="status"
                                                    value="disetujui"
                                                />
                                                <button
                                                    type="submit"
                                                    class="flex items-center gap-1 bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5 rounded-md text-xs font-bold transition shadow-sm"
                                                >
                                                    <svg
                                                        class="w-3 h-3"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M5 13l4 4L19 7"
                                                        ></path>
                                                    </svg>
                                                    Setujui
                                                </button>
                                            </form>

                                            {{-- Tombol Tolak (Buka Modal) --}}
                                            <button
                                                type="button"
                                                {{-- Simpan URL di atribut data-url agar editor tidak bingung --}}
                                                data-url="{{ route('admin.pengajuan.update', $item->id) }}"
                                                {{-- Ambil URL dari data-url saat diklik --}}
                                                onclick="
                                                    openRejectModal(
                                                        this.getAttribute(
                                                            'data-url'
                                                        )
                                                    )
                                                "
                                                class="flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md text-xs font-bold transition shadow-sm"
                                            >
                                                <svg
                                                    class="w-3 h-3"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"
                                                    ></path>
                                                </svg>
                                                Tolak
                                            </button>
                                        </div>
                                    @else
                                        {{-- Badge Status Jika Sudah Diproses --}}
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-bold border flex items-center gap-1 {{ $item->status_pengajuan == 'disetujui' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-red-50 text-red-600 border-red-200' }}"
                                        >
                                            @if ($item->status_pengajuan == 'disetujui')
                                                <svg
                                                    class="w-3 h-3"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M5 13l4 4L19 7"
                                                    ></path>
                                                </svg>
                                            @else
                                                <svg
                                                    class="w-3 h-3"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"
                                                    ></path>
                                                </svg>
                                            @endif
                                            {{ ucfirst($item->status_pengajuan) }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="4"
                                class="px-6 py-10 text-center text-gray-500 bg-gray-50"
                            >
                                <div class="flex flex-col items-center">
                                    <svg
                                        class="w-10 h-10 text-gray-300 mb-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                        ></path>
                                    </svg>
                                    <span class="font-medium">
                                        Belum ada data pengajuan cuti.
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 3. PAGINATION --}}
        <div class="p-5 border-t border-gray-100">
            {{ $pengajuan->appends(request()->query())->links() }}
        </div>
    </div>

    {{-- 4. MODAL TOLAK (POP-UP) --}}
    <div
        id="rejectModal"
        class="fixed inset-0 z-50 hidden overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        {{-- Backdrop --}}
        <div
            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
        >
            <div
                class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm"
                onclick="closeRejectModal()"
            ></div>
            <span
                class="hidden sm:inline-block sm:align-middle sm:h-screen"
                aria-hidden="true"
            >
                &#8203;
            </span>

            {{-- Konten Modal --}}
            <div
                class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full"
            >
                <form id="rejectForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="ditolak" />

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                            >
                                <svg
                                    class="h-6 w-6 text-red-600"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                    />
                                </svg>
                            </div>
                            <div
                                class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                            >
                                <h3
                                    class="text-lg leading-6 font-bold text-gray-900"
                                    id="modal-title"
                                >
                                    Tolak Pengajuan
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-2">
                                        Wajib menyertakan alasan penolakan agar
                                        karyawan dapat memahaminya.
                                    </p>
                                    <label
                                        class="block text-xs font-bold text-gray-700 mb-1"
                                    >
                                        Alasan Penolakan
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <textarea
                                        name="catatan"
                                        rows="3"
                                        required
                                        class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none"
                                        placeholder="Contoh: Kuota cuti divisi sedang penuh, mohon ajukan di tanggal lain."
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2"
                    >
                        <button
                            type="submit"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:w-auto sm:text-sm transition"
                        >
                            Konfirmasi Tolak
                        </button>
                        <button
                            type="button"
                            onclick="closeRejectModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm transition"
                        >
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT PENGENDALI MODAL --}}
    <script>
        function openRejectModal(actionUrl) {
            document.getElementById('rejectForm').action = actionUrl;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
@endsection
