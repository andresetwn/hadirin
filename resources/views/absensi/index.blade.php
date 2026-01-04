@extends('layouts.app')

@section('title', 'Absensi')
@section('header_title', 'ABSENSI')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-10 relative min-h-[550px]">

    @if (session('success'))
        <div class="mb-6 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm font-semibold">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $tanggalHariIni = \Carbon\Carbon::now()->format('Y-m-d');
        $jamSekarang = \Carbon\Carbon::now()->format('H:i');
        $sudahMasuk = !is_null($absenHariIni);
        $sudahPulang = ($absenHariIni && !is_null($absenHariIni->waktu_pulang));
    @endphp

    <form
        method="POST"
        action="{{ $sudahMasuk ? route('absensi.pulang') : route('absensi.masuk') }}"
        class="max-w-3xl"
        @if (!$sudahMasuk) enctype="multipart/form-data" @endif
    >
        @csrf

        <div class="mb-6 relative group">
            <input
                type="text"
                value="{{ \Illuminate\Support\Facades\Auth::user()->nip }}"
                readonly
                class="w-full pl-4 pr-10 py-3 rounded-lg border border-gray-300 bg-gray-50 focus:outline-none font-medium transition-colors"
            />
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
        </div>

        <div class="mb-6 relative group">
            <input
                type="text"
                value="{{ $tanggalHariIni }}"
                readonly
                class="w-full pl-4 pr-10 py-3 rounded-lg border border-gray-300 bg-gray-50 focus:outline-none font-bold text-gray-600 transition-colors"
            />
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

        <div class="mb-8 w-full sm:w-1/2">
            <input
                type="text"
                value="{{ $sudahMasuk ? \Carbon\Carbon::parse($absenHariIni->waktu_masuk)->format('H:i') : $jamSekarang }}"
                readonly
                class="w-full pl-4 py-3 rounded-lg border border-gray-300 bg-gray-50 focus:outline-none font-bold text-gray-500"
            />
        </div>

        {{-- SHIFT --}}
        @if (!$sudahMasuk)
            <div class="mb-6">
                <label class="block text-gray-500 font-bold mb-2 text-sm">Pilih Shift</label>

                <select
                    name="id_jam_kerja"
                    required
                    class="w-full pl-4 pr-10 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] font-bold text-gray-600 transition-colors appearance-none bg-white"
                >
                    <option value="" disabled {{ old('id_jam_kerja') ? '' : 'selected' }}>Pilih Shift</option>

                    @foreach ($shiftAktif as $s)
                        <option value="{{ $s->id }}" {{ old('id_jam_kerja') == $s->id ? 'selected' : '' }}>
                            {{ $s->nama_shift }} ({{ substr($s->jam_masuk, 0, 5) }} - {{ substr($s->jam_pulang, 0, 5) }})
                        </option>
                    @endforeach
                </select>
            </div>
        @else
            <div class="mb-6">
                <label class="block text-gray-500 font-bold mb-2 text-sm">Shift</label>
                <input
                    type="text"
                    readonly
                    value="{{ $namaShiftDipilih ?? '-' }}"
                    class="w-full pl-4 pr-10 py-3 rounded-lg border border-gray-300 bg-gray-50 focus:outline-none font-bold text-gray-600 transition-colors"
                />
            </div>
        @endif

        {{-- Upload hanya untuk Masuk --}}
        @if (!$sudahMasuk)
            <div class="mb-8">
                <label class="block text-gray-700 font-semibold mb-2 text-sm">Bukti Kehadiran</label>

                <input
                    id="bukti_foto"
                    name="bukti_foto"
                    type="file"
                    accept="image/*"
                    capture="environment"
                    class="hidden"
                    required
                />

                <label
                    for="bukti_foto"
                    class="w-28 h-28 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center cursor-pointer hover:bg-gray-50 hover:border-[#6379F1] transition group"
                    title="Klik untuk upload foto"
                >
                    <svg class="h-8 w-8 text-gray-400 group-hover:text-[#6379F1] transition"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                </label>

                <p class="text-red-500 text-[11px] mt-2 font-medium">
                    *foto harus terlihat tanggal dan waktu
                </p>
                <p id="nama_file" class="text-xs text-gray-600 mt-2 font-medium hidden"></p>
            </div>
        @else
            <div class="mb-8">
                <label class="block text-gray-700 font-semibold mb-2 text-sm">Bukti Kehadiran</label>

                <div class="flex items-center gap-3">
                    <div class="w-28 h-28 border border-gray-200 rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center">
                        @if (!empty($absenHariIni->bukti_foto))
                            <img
                                src="{{ asset('storage/' . $absenHariIni->bukti_foto) }}"
                                class="w-full h-full object-cover"
                                alt="Bukti Kehadiran"
                            />
                        @else
                            <span class="text-xs text-gray-500">Tidak ada foto</span>
                        @endif
                    </div>

                    <div class="text-sm text-gray-700">
                        <div class="font-semibold">Status:</div>
                        <div class="font-bold">
                            @if ($sudahPulang)
                                Sudah Masuk dan Pulang
                            @else
                                Sudah Masuk, belum Pulang
                            @endif
                        </div>

                        @if ($sudahPulang)
                            <div class="mt-2 text-xs text-gray-500">
                                Waktu pulang: {{ \Carbon\Carbon::parse($absenHariIni->waktu_pulang)->format('H:i') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-8 md:absolute md:bottom-10 md:right-10 flex justify-end">
            @if (!$sudahMasuk)
                <button type="submit"
                        class="bg-[#6379F1] hover:bg-indigo-600 text-white font-bold py-3 px-12 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    Masuk
                </button>
            @elseif (!$sudahPulang)
                <button type="submit"
                        class="bg-[#6379F1] hover:bg-indigo-600 text-white font-bold py-3 px-12 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    Pulang
                </button>
            @else
                <button type="button" disabled
                        class="bg-gray-300 text-white font-bold py-3 px-12 rounded-lg cursor-not-allowed">
                    Selesai
                </button>
            @endif
        </div>

    </form>
</div>

<script>
(function () {
    var input = document.getElementById("bukti_foto");
    if (!input) return;

    input.addEventListener("change", function () {
        var label = document.getElementById("nama_file");
        if (!label) return;

        if (input.files && input.files.length > 0) {
            label.textContent = "File dipilih: " + input.files[0].name;
            label.classList.remove("hidden");
        } else {
            label.textContent = "";
            label.classList.add("hidden");
        }
    });
})();
</script>
@endsection
