{{-- resources/views/admin/riwayat_absensi/index.blade.php --}}
{{-- UBAH JADI 6 KOLOM + tambahkan kolom AKSI --}}

@extends('layouts.admin')

@section('title', 'Riwayat Absensi')
@section('header_title', 'Riwayat Absensi')

@section('content')
    <div class="flex gap-6">
        <main class="flex-1">
            <div
                class="bg-white rounded-xl border border-gray-200 shadow-sm p-6"
            >
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <div class="text-xs text-gray-400">
                            Admin > Riwayat Absensi
                        </div>
                        <h1 class="text-xl font-bold text-gray-800">
                            Riwayat Absensi
                        </h1>
                    </div>

                    <a
                        href="{{ route('admin.riwayat_absensi.export', ['range' => $filter['range'], 'departemen' => $filter['departemen'], 'q' => $filter['q']]) }}"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-4 py-2 rounded-lg shadow"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                            />
                        </svg>
                        Ekspor CSV
                    </a>
                </div>

                {{-- FILTER --}}
                <form
                    method="GET"
                    action="{{ route('admin.riwayat_absensi') }}"
                    class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5"
                >
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <label class="text-sm font-bold text-gray-500">
                                Rentang Tanggal
                            </label>

                            {{-- TOMBOL CEPAT (QUICK FILTERS) --}}
                            <div class="flex gap-1">
                                <button
                                    type="button"
                                    onclick="setQuickDate('today')"
                                    class="text-[10px] font-bold bg-gray-100 hover:bg-indigo-100 text-gray-600 hover:text-indigo-600 px-2 py-1 rounded border border-gray-200 transition"
                                >
                                    Hari Ini
                                </button>
                                <button
                                    type="button"
                                    onclick="setQuickDate('week')"
                                    class="text-[10px] font-bold bg-gray-100 hover:bg-indigo-100 text-gray-600 hover:text-indigo-600 px-2 py-1 rounded border border-gray-200 transition"
                                >
                                    7 Hari
                                </button>
                                <button
                                    type="button"
                                    onclick="setQuickDate('month')"
                                    class="text-[10px] font-bold bg-gray-100 hover:bg-indigo-100 text-gray-600 hover:text-indigo-600 px-2 py-1 rounded border border-gray-200 transition"
                                >
                                    Bulan Ini
                                </button>
                            </div>
                        </div>

                        <div class="relative">
                            {{-- Icon Kalender --}}
                            <div
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400"
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
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    ></path>
                                </svg>
                            </div>

                            {{-- Input Flatpickr --}}
                            <input
                                id="dateRangePicker"
                                name="range"
                                value="{{ $filter['range'] }}"
                                placeholder="Pilih Rentang Tanggal"
                                class="w-full pl-10 border border-gray-300 rounded-xl px-3 py-2.5 font-semibold text-gray-700 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 bg-white cursor-pointer"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-500">
                            Departemen
                        </label>
                        <select
                            onchange="this.form.submit()"
                            name="departemen"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 font-semibold text-gray-700 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                            <option value="">Semua Departemen</option>
                            @foreach ($departemenList as $d)
                                <option
                                    value="{{ $d->id }}"
                                    {{ (string) $filter['departemen'] === (string) $d->id ? 'selected' : '' }}
                                >
                                    {{ $d->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-500">
                            Cari Nama/NIP
                        </label>
                        <div class="mt-2 flex gap-2">
                            <input
                                name="q"
                                value="{{ $filter['q'] }}"
                                placeholder="Ketik Nama/NIP"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 font-semibold text-gray-700 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                            />
                            <button
                                type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-4 rounded-lg"
                            >
                                Cari
                            </button>
                        </div>
                    </div>
                </form>

                {{-- TABLE --}}
                <div class="overflow-hidden rounded-xl border border-gray-200">
                    <div
                        class="grid grid-cols-6 gap-2 bg-gray-50 px-4 py-3 text-xs font-bold uppercase tracking-wide text-gray-600"
                    >
                        <div>Nama Karyawan</div>
                        <div>Tanggal</div>
                        <div>Masuk</div>
                        <div>Keluar</div>
                        <div class="text-right">Status</div>
                        <div class="text-right">Aksi</div>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @forelse ($rows as $r)
                            <div
                                class="grid grid-cols-6 gap-2 px-4 py-4 text-sm items-center"
                            >
                                <div>
                                    <div class="font-bold text-gray-800">
                                        {{ $r['nama'] }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        NIP: {{ $r['nip'] }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $r['departemen'] }}
                                    </div>
                                </div>

                                <div class="font-semibold text-gray-700">
                                    {{ $r['tanggal'] }}
                                </div>
                                <div class="font-semibold text-gray-700">
                                    {{ $r['masuk'] }}
                                </div>
                                <div class="font-semibold text-gray-700">
                                    {{ $r['keluar'] }}
                                </div>

                                <div class="text-right">
                                    @php
                                        $status = $r['status_key'];
                                        $cls = 'bg-green-100 text-green-700';
                                        if ($status === 'terlambat') {
                                            $cls = 'bg-red-100 text-red-700';
                                        }
                                        if ($status === 'cuti') {
                                            $cls = 'bg-yellow-100 text-yellow-700';
                                        }
                                    @endphp

                                    <span
                                        class="inline-flex px-3 py-1 rounded-full text-xs font-bold {{ $cls }}"
                                    >
                                        {{ $r['status'] }}
                                    </span>
                                </div>

                                <div class="text-right">
                                    {{-- tombol detail hanya untuk absensi (bukan cuti) --}}

                                    @if (! empty($r['id_absensi']))
                                        <a
                                            href="{{ route('admin.riwayat_absensi.show', $r['id_absensi']) }}"
                                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold"
                                        >
                                            Detail
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">
                                            -
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div
                                class="px-4 py-10 text-center text-gray-500 font-bold"
                            >
                                Tidak ada data.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- FOOTER + PAGINATION --}}
                <div
                    class="flex items-center justify-between mt-4 text-sm text-gray-500"
                >
                    <div>
                        Menampilkan
                        {{ ($pagination['page'] - 1) * $pagination['perPage'] + 1 }}
                        -
                        {{ min($pagination['page'] * $pagination['perPage'], $pagination['total']) }}
                        dari {{ $pagination['total'] }} entri
                    </div>

                    <div class="flex items-center gap-2">
                        @php
                            $page = $pagination['page'];
                            $last = $pagination['lastPage'];
                            $baseParams = [
                                'range' => $filter['range'],
                                'departemen' => $filter['departemen'],
                                'q' => $filter['q'],
                            ];
                        @endphp

                        <a
                            class="px-3 py-1 rounded-lg border border-gray-300 {{ $page <= 1 ? 'pointer-events-none opacity-50' : '' }}"
                            href="{{ route('admin.riwayat_absensi', array_merge($baseParams, ['page' => max(1, $page - 1)])) }}"
                        >
                            ‹
                        </a>

                        @for ($p = 1; $p <= $last; $p++)
                            @if ($p <= 5 || $p == $last)
                                <a
                                    class="px-3 py-1 rounded-lg border border-gray-300 {{ $p == $page ? 'bg-indigo-600 text-white border-indigo-600' : '' }}"
                                    href="{{ route('admin.riwayat_absensi', array_merge($baseParams, ['page' => $p])) }}"
                                >
                                    {{ $p }}
                                </a>
                            @endif
                        @endfor

                        <a
                            class="px-3 py-1 rounded-lg border border-gray-300 {{ $page >= $last ? 'pointer-events-none opacity-50' : '' }}"
                            href="{{ route('admin.riwayat_absensi', array_merge($baseParams, ['page' => min($last, $page + 1)])) }}"
                        >
                            ›
                        </a>
                    </div>
                </div>
            </div>
            <script>
                let fpInstance; // Variabel untuk menyimpan instance Flatpickr

                document.addEventListener('DOMContentLoaded', function () {
                    // 1. Inisialisasi Flatpickr
                    fpInstance = flatpickr('#dateRangePicker', {
                        mode: 'range',
                        dateFormat: 'Y-m-d',
                        altInput: true,
                        altFormat: 'j F Y',
                        locale: {
                            rangeSeparator: ' sampai '
                        },
                        onChange: function (selectedDates, dateStr, instance) {
                            // Cari form terdekat dan submit
                            instance.element.closest('form').submit();
                        }
                    });
                });

                // 2. Fungsi untuk Tombol Cepat
                function setQuickDate(type) {
                    const today = new Date();
                    let start = new Date();
                    let end = new Date();

                    if (type === 'today') {
                        // Hari Ini: Start = Today, End = Today
                        start = today;
                    } else if (type === 'week') {
                        // 7 Hari Terakhir: Mundur 7 hari
                        start.setDate(today.getDate() - 6);
                    } else if (type === 'month') {
                        // Bulan Ini: Tanggal 1 sampai Hari Ini
                        start = new Date(
                            today.getFullYear(),
                            today.getMonth(),
                            1
                        );
                    }

                    // Update Flatpickr dengan rentang baru
                    if (fpInstance) {
                        fpInstance.setDate([start, end], true); // true = trigger change event (agar input terisi)
                    }
                }
            </script>
        </main>
    </div>
@endsection
