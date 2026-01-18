<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanCutiController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajuanCuti::with(['pengguna', 'jenis_cuti']);


        if ($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->whereHas('pengguna', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }
        $pengajuan = $query->orderByRaw("FIELD(status_pengajuan, 'menunggu', 'disetujui', 'ditolak')")
            ->orderBy('dibuat_pada', 'desc')
            ->paginate(10);

        return view('admin.pengajuan.index', compact('pengajuan'));
    }
    public function show($id)
    {
        $cuti = PengajuanCuti::with(['pengguna.jabatan', 'pengguna.departemen', 'jenis_cuti'])->findOrFail($id);
        return view('admin.pengajuan.show', compact('cuti'));
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => 'required_if:status,ditolak'
        ]);

        $cuti = PengajuanCuti::findOrFail($id);

        $cuti->update([
            'status_pengajuan' => $request->status,
            'disetujui_oleh' => Auth::id(),
            'disetujui_pada' => now(),
            'catatan_admin' => $request->catatan
        ]);

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
