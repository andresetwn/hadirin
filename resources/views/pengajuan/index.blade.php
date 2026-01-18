@extends('layouts.app') @section('title', 'Pengajuan Cuti')
@section('header_title', 'Pengajuan Cuti') @section('content')
<div
    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-10 relative min-h-[550px]"
>
    <form
        action="{{ route('pengajuan.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="max-w-4xl"
    >
        @csrf @if (session('success'))
        <div
            class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 font-bold text-sm"
        >
            {{ session("success") }}
        </div>
        @endif @if ($errors->any())
        <div
            class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 font-bold text-sm"
        >
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- JENIS PENGAJUAN --}}
        <div class="mb-6">
            <label class="block text-gray-500 font-bold mb-2 text-sm"
                >Jenis Pengajuan</label
            >
            <div class="relative group">
                <select
                    name="id_jenis_cuti"
                    required
                    class="w-full pl-4 pr-10 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] font-bold text-gray-600 transition-colors appearance-none bg-white"
                >
                    <option value="" disabled selected>
                        Pilih Jenis Pengajuan
                    </option>
                    <option value="1">Cuti Tahunan</option>
                    <option value="2">Cuti Khusus</option>
                    <option value="3">Cuti Sakit</option>
                    <option value="4">Cuti Melahirkan</option>
                    <option value="5">Cuti Haid</option>
                </select>

                <!-- Arrow -->
                <div
                    class="absolute inset-y-0 right-4 flex items-center pointer-events-none"
                >
                    <svg
                        class="w-5 h-5 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"
                        />
                    </svg>
                </div>
            </div>
        </div>

        {{-- ROW TANGGAL (GRID 2 KOLOM) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- TANGGAL MULAI --}}
            <div>
                <label class="block text-gray-500 font-bold mb-2 text-sm"
                    >Tanggal Mulai</label
                >
                <div class="relative group">
                    <input
                        name="tanggal_mulai"
                        type="text"
                        placeholder="Pilih Tanggal"
                        onfocus="(this.type='date')"
                        onblur="(this.type='text')"
                        class="w-full pl-4 pr-10 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] placeholder-gray-300 font-bold text-gray-600 transition-colors"
                    />
                </div>
            </div>

            {{-- TANGGAL SELESAI --}}
            <div>
                <label class="block text-gray-500 font-bold mb-2 text-sm"
                    >Tanggal Selesai</label
                >
                <div class="relative group">
                    <input
                        name="tanggal_selesai"
                        type="text"
                        placeholder="Pilih Tanggal"
                        onfocus="(this.type='date')"
                        onblur="(this.type='text')"
                        class="w-full pl-4 pr-10 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] placeholder-gray-300 font-bold text-gray-600 transition-colors"
                    />
                </div>
            </div>
        </div>

        {{-- ALASAN / KETERANGAN --}}
        <div class="mb-6">
            <label class="block text-gray-500 font-bold mb-2 text-sm"
                >Alasan / Keterangan</label
            >
            <div class="relative group">
                <input
                    name="alasan"
                    type="text"
                    placeholder="Deskripsikan"
                    class="w-full pl-4 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-[#6379F1] focus:ring-1 focus:ring-[#6379F1] placeholder-gray-300 font-bold text-gray-600 transition-colors"
                />
            </div>
        </div>

        {{-- LAMPIRAN --}}
        <div class="mb-8">
            <label class="block text-gray-500 font-bold mb-2 text-sm"
                >Lampiran</label
            >

            <div class="flex items-center gap-4">
                <!-- Box upload -->
                <label
                    for="lampiran"
                    id="uploadBox"
                    class="w-28 h-24 border border-gray-400 flex items-center justify-center cursor-pointer hover:bg-gray-50 hover:border-[#6379F1] transition group rounded-lg"
                >
                    <!-- Plus Icon -->
                    <svg
                        id="iconPlus"
                        class="h-6 w-6 text-black group-hover:text-[#6379F1] transition"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="3"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>

                    <!-- Edit Icon (hidden) -->
                    <svg
                        id="iconEdit"
                        class="h-6 w-6 text-black group-hover:text-[#6379F1] transition hidden"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M11 5h2m2 0h.01M4 21h4l11-11a2.5 2.5 0 10-3.5-3.5L4 17v4z"
                        />
                    </svg>
                </label>

                <!-- Input file -->
                <input
                    id="lampiran"
                    name="lampiran"
                    type="file"
                    class="hidden"
                    accept=".pdf,.jpg,.jpeg,.png"
                    onchange="handleFileChange(this)"
                    required
                />

                <!-- File info -->
                <div>
                    <p class="text-sm font-bold text-gray-600">File dipilih:</p>
                    <p id="lampiran_name" class="text-sm text-gray-400">
                        Belum ada file dipilih
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        Klik kotak untuk tambah/ubah file
                    </p>
                </div>
            </div>
        </div>

        {{-- BUTTON KIRIM --}}
        <div class="mt-8 flex justify-end">
            <button
                type="submit"
                class="bg-[#6379F1] hover:bg-indigo-600 text-white font-bold py-3 px-12 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5"
            >
                Kirim
            </button>
        </div>
    </form>
</div>
<script>
    function handleFileChange(input) {
        if (input.files && input.files.length > 0) {
            document.getElementById("lampiran_name").innerText =
                input.files[0].name;
            document.getElementById("iconPlus").classList.add("hidden");
            document.getElementById("iconEdit").classList.remove("hidden");
            document
                .getElementById("uploadBox")
                .classList.add("border-[#6379F1]");
        }
    }
</script>
@endsection
