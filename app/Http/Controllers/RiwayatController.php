<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\PengajuanCuti;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', now()->format('m'));
        $tahun = $request->get('tahun', now()->format('Y'));
        $q = trim((string) $request->get('q', ''));

        // Ambil absensi user login
        $absensi = Absensi::where('id_pengguna', Auth::id())
            ->whereMonth('tanggal', (int)$bulan)
            ->whereYear('tanggal', (int)$tahun);

        // Search sederhana
        if ($q !== '') {
            $absensi->where(function ($s) use ($q) {
                $s->where('status', 'like', '%' . $q . '%')
                    ->orWhere('status', 'like', '%' . $q . '%');
            });
        }

        $absensi = $absensi->get()->map(function ($a) {
            return [
                'tanggal' => Carbon::parse($a->tanggal)->format('Y-m-d'),
                'masuk' => ($a->waktu_masuk && $a->waktu_masuk != '0000-00-00 00:00:00')
                    ? \Carbon\Carbon::parse($a->waktu_masuk)->format('H:i')
                    : '-',

                'pulang' => ($a->waktu_pulang && $a->waktu_pulang != '0000-00-00 00:00:00')
                    ? \Carbon\Carbon::parse($a->waktu_pulang)->format('H:i')
                    : '-',
                'status' => strtoupper($a->status ?? 'HADIR'),
            ];
        });

        // Ambil cuti user login (yang disetujui saja agar muncul sebagai CUTI)
        $cuti = PengajuanCuti::where('id_pengguna', Auth::id())
            ->where('status_pengajuan', 'disetujui')
            ->whereMonth('tanggal_mulai', (int)$bulan)
            ->whereYear('tanggal_mulai', (int)$tahun)
            ->get()
            ->flatMap(function ($c) {
                // pecah jadi per hari untuk tampilkan di riwayat
                $mulai = Carbon::parse($c->tanggal_mulai);
                $selesai = Carbon::parse($c->tanggal_selesai);

                $days = [];
                for ($d = $mulai->copy(); $d->lte($selesai); $d->addDay()) {
                    $days[] = [
                        'tanggal' => $d->format('Y-m-d'),
                        'masuk' => '00.00',
                        'pulang' => '00.00',
                        'status' => 'CUTI',
                    ];
                }

                return $days;
            });

        // Gabungkan, kalau tanggal bentrok, CUTI menang
        $gabung = collect()
            ->concat($absensi)
            ->concat($cuti)
            ->groupBy('tanggal')
            ->map(function ($items) {
                $cutiItem = $items->firstWhere('status', 'CUTI');
                return $cutiItem ? $cutiItem : $items->first();
            })
            ->values()
            ->sortByDesc('tanggal')
            ->values();

        return view('riwayat.index', [
            'dataRiwayat' => $gabung,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'q' => $q,
        ]);
    }
}
