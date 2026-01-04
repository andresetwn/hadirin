<?php

namespace App\Http\Controllers;

use App\Models\PengajuanCuti;
use App\Models\JenisCuti;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanCutiController extends Controller
{
    public function create()
    {
        $jenisCuti = JenisCuti::where('status_aktif', 1)
            ->orderBy('nama_cuti')
            ->get();

        return view('pengajuan.index', compact('jenisCuti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jenis_cuti'   => 'required|integer|exists:jenis_cuti,id',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan'          => 'required|min:3',
            'lampiran'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
        ]);


        $jenis = JenisCuti::where('id', (int)$request->id_jenis_cuti)
            ->where('status_aktif', 1)
            ->first();

        if (!$jenis) {
            return back()->withErrors([
                'id_jenis_cuti' => 'Jenis cuti tidak aktif.'
            ])->withInput();
        }
        $mulai = Carbon::parse($request->tanggal_mulai);
        $selesai = Carbon::parse($request->tanggal_selesai);
        $jumlahHari = $mulai->diffInDays($selesai) + 1;

        if (!is_null($jenis->batas_hari) && $jumlahHari > (int)$jenis->batas_hari) {
            return back()->withErrors([
                'tanggal_selesai' => 'Pengajuan melebihi batas (' . (int)$jenis->batas_hari . ' hari).'
            ])->withInput();
        }
        if ((int)$jenis->wajib_lampiran === 1 && !$request->hasFile('lampiran')) {
            return back()->withErrors([
                'lampiran' => 'Jenis cuti ini wajib lampiran.'
            ])->withInput();
        }

        // simpan file (WAJIB)
        $lampiranPath = $request->file('lampiran')->store('lampiran_cuti', 'public');

        PengajuanCuti::create([
            'id_pengguna'      =>  Auth::id(),
            'id_jenis_cuti'    => (int)$request->id_jenis_cuti,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_selesai'  => $request->tanggal_selesai,
            'jumlah_hari'      => $jumlahHari,
            'alasan'           => $request->alasan,
            'lampiran_file'    => $lampiranPath,
            'status_pengajuan' => 'menunggu',
            'disetujui_oleh'   => null,
            'disetujui_pada'   => null,
            'catatan_admin'    => null,
        ]);

        return redirect()->route('pengajuan')->with('success', 'Pengajuan berhasil dikirim.');
    }
}
