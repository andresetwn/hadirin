<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanCutiController extends Controller
{
    // Halaman Daftar (Sesuai Gambar image_182863.png)
    public function index(Request $request)
    {
        // Load relasi pengguna dan jenis_cuti agar tidak N+1 Query
        $query = PengajuanCuti::with(['pengguna', 'jenis_cuti']);

        // Search Logic
        if ($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->whereHas('pengguna', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        // Urutkan: Menunggu paling atas, lalu tanggal terbaru
        $pengajuan = $query->orderByRaw("FIELD(status_pengajuan, 'menunggu', 'disetujui', 'ditolak')")
            ->orderBy('dibuat_pada', 'desc')
            ->paginate(10);

        return view('admin.pengajuan.index', compact('pengajuan'));
    }

    // Halaman Detail (Sesuai Gambar image_18289c.png)
    public function show($id)
    {
        $cuti = PengajuanCuti::with(['pengguna.jabatan', 'pengguna.departemen', 'jenis_cuti'])->findOrFail($id);
        return view('admin.pengajuan.show', compact('cuti'));
    }

    // Aksi Approval
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string'
        ]);

        $cuti = PengajuanCuti::findOrFail($id);

        $cuti->update([
            'status_pengajuan' => $request->status,
            'disetujui_oleh' => Auth::id(), // Simpan ID Admin yang login
            'disetujui_pada' => now(),
            'catatan_admin' => $request->catatan // Jika ada alasan penolakan
        ]);

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
