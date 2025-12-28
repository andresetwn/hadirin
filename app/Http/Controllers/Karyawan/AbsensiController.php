<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $absenHariIni = DB::table('absensi')
            ->where('id_pengguna', Auth::id())
            ->where('tanggal', now()->toDateString())
            ->first();

        return view('absensi.index', compact('absenHariIni'));
    }

    public function masuk(Request $request)
    {
        $absenHariIni = DB::table('absensi')
            ->where('id_pengguna', Auth::id())
            ->where('tanggal', now()->toDateString())
            ->first();

        if ($absenHariIni) {
            return back()->withErrors(['absensi' => 'Anda sudah absen masuk hari ini.']);
        }

        $request->validate([
            'bukti_foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $path = $request->file('bukti_foto')->store('absensi', 'public');

        DB::table('absensi')->insert([
            'id_pengguna' => Auth::id(),
            'tanggal' => now()->toDateString(),
            'waktu_masuk' => now(),
            'status' => 'hadir',
            'bukti_foto' => $path,
            'dibuat_pada' => now(),
            'diubah_pada' => now(),
        ]);

        return back()->with('success', 'Absen masuk berhasil.');
    }

    public function pulang(Request $request)
    {
        $absenHariIni = DB::table('absensi')
            ->where('id_pengguna', Auth::id())
            ->where('tanggal', now()->toDateString())
            ->first();

        if (!$absenHariIni) {
            return back()->withErrors(['absensi' => 'Anda belum absen masuk hari ini.']);
        }

        if (!is_null($absenHariIni->waktu_pulang)) {
            return back()->withErrors(['absensi' => 'Anda sudah absen pulang hari ini.']);
        }

        DB::table('absensi')
            ->where('id', $absenHariIni->id)
            ->update([
                'waktu_pulang' => now(),
                'diubah_pada' => now(),
            ]);

        return back()->with('success', 'Absen pulang berhasil.');
    }
}
