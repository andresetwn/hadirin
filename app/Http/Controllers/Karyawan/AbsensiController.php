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

        $shiftAktif = DB::table('jam_kerja')
            ->where('status_aktif', 1)
            ->orderBy('id', 'asc')
            ->get();

        $namaShiftDipilih = null;

        if ($absenHariIni && !empty($absenHariIni->id_jam_kerja)) {
            $shift = DB::table('jam_kerja')->where('id', $absenHariIni->id_jam_kerja)->first();
            if ($shift) {
                $namaShiftDipilih = $shift->nama_shift . ' (' . substr($shift->jam_masuk, 0, 5) . ' - ' . substr($shift->jam_pulang, 0, 5) . ')';
            }
        }

        return view('absensi.index', compact('absenHariIni', 'shiftAktif', 'namaShiftDipilih'));
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
            'id_jam_kerja' => 'required|integer|exists:jam_kerja,id',
            'bukti_foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $shift = DB::table('jam_kerja')
            ->where('id', (int)$request->id_jam_kerja)
            ->where('status_aktif', 1)
            ->first();

        if (!$shift) {
            return back()->withErrors(['id_jam_kerja' => 'Shift tidak valid atau tidak aktif.'])->withInput();
        }

        // =========================================================
        // VALIDASI: tidak boleh absen di luar jam kerja shift
        // - boleh masuk mulai dari jam_masuk sampai jam_pulang
        // - kalau kamu mau pakai toleransi sebagai "batas telat", tetap bisa
        // =========================================================
        $jamMasukShift = $shift->jam_masuk;   // TIME
        $jamPulangShift = $shift->jam_pulang; // TIME

        $now = now();

        $startWindow = \Carbon\Carbon::parse($now->toDateString() . ' ' . $jamMasukShift);
        $endWindow = \Carbon\Carbon::parse($now->toDateString() . ' ' . $jamPulangShift);

        // kalau shift melewati tengah malam (contoh 23:00 - 07:00)
        if ($endWindow->lessThan($startWindow)) {
            $endWindow->addDay();
            // jika sekarang masih sebelum jam masuk (misal jam 01:00), berarti masuk di hari berikutnya
            if ($now->lessThan($startWindow)) {
                $startWindow->subDay();
                $endWindow->subDay();
            }
        }

        if ($now->lessThan($startWindow) || $now->greaterThan($endWindow)) {
            return back()->withErrors([
                'absensi' => 'Tidak dapat absen di luar jam kerja. Jam shift Anda: ' . substr($jamMasukShift, 0, 5) . ' - ' . substr($jamPulangShift, 0, 5) . '.'
            ])->withInput();
        }

        // =========================================================
        // HITUNG STATUS HADIR / TERLAMBAT
        // - terlambat jika lewat jam_masuk + toleransi_menit
        // =========================================================
        $toleransi = (int)($shift->toleransi_menit ?? 0);
        $batasMasuk = \Carbon\Carbon::parse($now->toDateString() . ' ' . $jamMasukShift)->addMinutes($toleransi);

        // handle shift lewat tengah malam untuk batasMasuk
        if ($batasMasuk->lessThan($startWindow)) {
            $batasMasuk = $startWindow->copy()->addMinutes($toleransi);
        }

        $status = 'hadir';
        if ($now->greaterThan($batasMasuk)) {
            $status = 'terlambat';
        }

        $path = $request->file('bukti_foto')->store('absensi', 'public');

        DB::table('absensi')->insert([
            'id_pengguna' => Auth::id(),
            'id_jam_kerja' => (int)$request->id_jam_kerja,
            'tanggal' => $now->toDateString(),
            'waktu_masuk' => $now,
            'waktu_pulang' => null,
            'status' => $status,
            'bukti_foto' => $path,
            'catatan' => null,
            'dibuat_pada' => $now,
            'diubah_pada' => $now,
        ]);

        return back()->with('success', 'Absen masuk berhasil. Status: ' . strtoupper($status));
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

        // Optional: kalau kamu mau, validasi pulang juga harus dalam jam shift.
        // Saat ini saya biarkan bebas agar tidak menghambat.

        DB::table('absensi')
            ->where('id', $absenHariIni->id)
            ->update([
                'waktu_pulang' => now(),
                'diubah_pada' => now(),
            ]);

        return back()->with('success', 'Absen pulang berhasil.');
    }
}
