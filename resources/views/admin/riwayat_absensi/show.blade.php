{{-- resources/views/admin/riwayat_absensi/show.blade.php --}}

@extends('layouts.admin')

@section('title', 'Detail Absensi')
@section('header_title', 'Detail Absensi')

@section('content')
<div class="max-w-5xl mx-auto">

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

    <div class="flex items-center justify-between mb-4">
        <div>
            <div class="text-xs text-gray-400">Admin > Riwayat Absensi > Detail Absensi</div>
            <h1 class="text-xl font-bold text-gray-800">Edit Absensi</h1>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.riwayat_absensi') }}"
               class="px-4 py-2 rounded-lg border border-gray-300 font-bold text-gray-700 hover:bg-gray-50">
                Kembali
            </a>

            <form action="{{ route('admin.riwayat_absensi.destroy', $row->id) }}" method="POST"
                  onsubmit="return confirm('Yakin hapus data absensi ini?')">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <div class="text-xs text-gray-400 font-bold">Nama Karyawan</div>
                <div class="font-bold text-gray-800">{{ $row->nama_lengkap }}</div>
                <div class="text-xs text-gray-500">NIP: {{ $row->nip }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-400 font-bold">Jabatan</div>
                <div class="font-bold text-gray-800">{{ $row->jabatan ?: '-' }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-400 font-bold">Departemen</div>
                <div class="font-bold text-gray-800">{{ $row->departemen ?: '-' }}</div>
            </div>
        </div>

        <form action="{{ route('admin.riwayat_absensi.update', $row->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-bold text-gray-500">Tanggal</label>
                    <input readonly value="{{ \Carbon\Carbon::parse($row->tanggal)->format('l, d F Y') }}"
                           class="mt-2 w-full border border-gray-200 rounded-lg px-3 py-2 font-semibold text-gray-700 bg-gray-50" />
                </div>

                <div>
                    <label class="text-sm font-bold text-gray-500">Status</label>
                    <select name="status" class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 font-semibold text-gray-700">
                        <option value="hadir" {{ $row->status === 'hadir' ? 'selected' : '' }}>Tepat Waktu</option>
                        <option value="terlambat" {{ $row->status === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-bold text-gray-500">Waktu Masuk</label>
                    <input name="waktu_masuk" type="datetime-local"
                           value="{{ $row->waktu_masuk ? \Carbon\Carbon::parse($row->waktu_masuk)->format('Y-m-d\TH:i') : '' }}"
                           class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 font-semibold text-gray-700" />
                </div>

                <div>
                    <label class="text-sm font-bold text-gray-500">Waktu Keluar</label>
                    <input name="waktu_pulang" type="datetime-local"
                           value="{{ $row->waktu_pulang ? \Carbon\Carbon::parse($row->waktu_pulang)->format('Y-m-d\TH:i') : '' }}"
                           class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 font-semibold text-gray-700" />
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-bold text-gray-500">Catatan</label>
                    <textarea name="catatan" rows="3"
                              class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 font-semibold text-gray-700">{{ old('catatan', $row->catatan) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-bold text-gray-500">Lampiran (Bukti Foto)</label>

                    <div class="mt-2 border border-gray-200 rounded-lg p-3 flex items-center justify-between">
                        <div class="text-sm text-gray-700 font-semibold">
                            @if (!empty($row->bukti_foto))
                                <a class="text-indigo-600 hover:underline" href="{{ asset('storage/'.$row->bukti_foto) }}" target="_blank">
                                    {{ basename($row->bukti_foto) }}
                                </a>
                            @else
                                <span class="text-gray-400">Tidak ada lampiran</span>
                            @endif
                        </div>

                        @if (!empty($row->bukti_foto))
                            <a class="text-gray-500 hover:text-gray-800" href="{{ asset('storage/'.$row->bukti_foto) }}" download>
                                Download
                            </a>
                        @endif
                    </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-2 rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
