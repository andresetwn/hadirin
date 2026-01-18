<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RiwayatAbsensiAdminController extends Controller
{
    private function ensureAdmin()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Akses ditolak. Anda belum login.');
        }

        $role = strtolower(trim((string) $user->role));

        if ($role !== 'admin') {
            abort(403, 'Akses ditolak. Role Anda: ' . ($role === '' ? '(kosong)' : $role));
        }
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();

        // Filter
        $range = trim((string)$request->get('range', ''));
        $departemenId = $request->get('departemen', '');
        $q = trim((string)$request->get('q', ''));
        $start = now()->startOfMonth()->toDateString();
        $end = now()->endOfMonth()->toDateString();
        if ($range !== '') {
            if (str_contains($range, ' sampai ')) {
                $parts = explode(' sampai ', $range);
                $start = trim($parts[0]);
                $end   = trim($parts[1] ?? $start);
            }
            elseif (str_contains($range, ' - ')) {
                $parts = explode(' - ', $range);
                $start = trim($parts[0]);
                $end   = trim($parts[1] ?? $start);
            }
            else {
                $start = $range;
                $end   = $range;
            }
            try {
                $start = Carbon::parse($start)->startOfDay()->toDateString();
                $end   = Carbon::parse($end)->endOfDay()->toDateString();
            } catch (\Exception $e) {
                $start = now()->startOfMonth()->toDateString();
                $end   = now()->endOfMonth()->toDateString();
            }
        }
        $departemenList = DB::table('departemen')->orderBy('id', 'asc')->get();
        $absensiQuery = DB::table('absensi')
            ->join('pengguna', 'pengguna.id', '=', 'absensi.id_pengguna')
            ->leftJoin('departemen', 'departemen.id', '=', 'pengguna.id_departemen')
            ->whereBetween('absensi.tanggal', [$start, $end]);

        if ($departemenId !== '' && is_numeric($departemenId)) {
            $absensiQuery->where('pengguna.id_departemen', (int)$departemenId);
        }

        if ($q !== '') {
            $absensiQuery->where(function ($s) use ($q) {
                $s->where('pengguna.nama', 'like', '%' . $q . '%')
                    ->orWhere('pengguna.nip', 'like', '%' . $q . '%');
            });
        }

        $absensiRows = $absensiQuery
            ->select([
                'pengguna.id as id_pengguna',
                'pengguna.nama_lengkap as nama',
                'pengguna.nip as nip',
                'departemen.nama_departemen as departemen',
                'absensi.id as id_absensi',
                'absensi.tanggal as tanggal',
                'absensi.waktu_masuk as waktu_masuk',
                'absensi.waktu_pulang as waktu_pulang',
                'absensi.status as status',
            ])
            ->orderBy('absensi.tanggal', 'desc')
            ->get()
            ->map(function ($r) {
                $masuk = ($r->waktu_masuk && $r->waktu_masuk != '0000-00-00 00:00:00')
                    ? Carbon::parse($r->waktu_masuk)->format('H:i')
                    : '-';

                $pulang = ($r->waktu_pulang && $r->waktu_pulang != '0000-00-00 00:00:00')
                    ? Carbon::parse($r->waktu_pulang)->format('H:i')
                    : '-';

                $label = 'Tepat Waktu';
                if ($r->status === 'terlambat') {
                    $label = 'Terlambat';
                }

                return [
                    'nama' => $r->nama,
                    'nip' => $r->nip,
                    'tanggal' => Carbon::parse($r->tanggal)->format('d F Y'),
                    'id_absensi' => $r->id_absensi,
                    'masuk' => $masuk,
                    'keluar' => $pulang,
                    'departemen' => $r->departemen ?: '-',
                    'status' => $label,
                    'status_key' => strtolower((string)$label),
                ];
            });
        $cutiQuery = PengajuanCuti::join('pengguna', 'pengguna.id', '=', 'pengajuan_cuti.id_pengguna')
            ->leftJoin('departemen', 'departemen.id', '=', 'pengguna.id_departemen')
            ->where('pengajuan_cuti.status_pengajuan', 'disetujui')
            ->whereDate('pengajuan_cuti.tanggal_mulai', '<=', $end)
            ->whereDate('pengajuan_cuti.tanggal_selesai', '>=', $start);

        if ($departemenId !== '' && is_numeric($departemenId)) {
            $cutiQuery->where('pengguna.id_departemen', (int)$departemenId);
        }

        if ($q !== '') {
            $cutiQuery->where(function ($s) use ($q) {
                $s->where('pengguna.nama', 'like', '%' . $q . '%')
                    ->orWhere('pengguna.nip', 'like', '%' . $q . '%');
            });
        }

        $cutiRowsRaw = $cutiQuery->select([
            'pengguna.nama_lengkap as nama',
            'pengguna.nip as nip',
            'departemen.nama_departemen as departemen',
            'pengajuan_cuti.tanggal_mulai as tanggal_mulai',
            'pengajuan_cuti.tanggal_selesai as tanggal_selesai',
        ])->get();

        $cutiRows = collect();

        foreach ($cutiRowsRaw as $c) {
            $mulai = Carbon::parse($c->tanggal_mulai)->startOfDay();
            $selesai = Carbon::parse($c->tanggal_selesai)->startOfDay();

            $rangeStart = Carbon::parse($start)->startOfDay();
            $rangeEnd = Carbon::parse($end)->startOfDay();

            if ($mulai->lt($rangeStart)) $mulai = $rangeStart->copy();
            if ($selesai->gt($rangeEnd)) $selesai = $rangeEnd->copy();

            for ($d = $mulai->copy(); $d->lte($selesai); $d->addDay()) {
                $cutiRows->push([
                    'id_absensi' => null,
                    'nama' => $c->nama,
                    'nip' => $c->nip,
                    'tanggal' => $d->format('d F Y'),
                    'masuk' => '-',
                    'keluar' => '-',
                    'departemen' => $c->departemen ?: '-',
                    'status' => 'Cuti',
                    'status_key' => 'cuti',
                ]);
            }
        }
        $merged = collect()
            ->concat($absensiRows)
            ->concat($cutiRows)
            ->groupBy(function ($row) {
                return $row['nip'] . '|' . $row['tanggal'];
            })
            ->map(function ($items) {
                $cuti = $items->firstWhere('status', 'Cuti');
                return $cuti ? $cuti : $items->first();
            })
            ->values()
            ->sortByDesc(function ($row) {
                return Carbon::createFromFormat('d F Y', $row['tanggal'])->format('Y-m-d');
            })
            ->values();
        $perPage = 10;
        $page = (int)$request->get('page', 1);
        if ($page < 1) $page = 1;

        $total = $merged->count();
        $items = $merged->slice(($page - 1) * $perPage, $perPage)->values();

        $lastPage = (int)ceil($total / $perPage);
        if ($lastPage < 1) $lastPage = 1;

        return view('admin.riwayat_absensi.index', [
            'rows' => $items,
            'departemenList' => $departemenList,
            'filter' => [
                'range' => $range !== '' ? $range : ($start . ' sampai ' . $end),
                'departemen' => $departemenId,
                'q' => $q,
            ],
            'pagination' => [
                'page' => $page,
                'perPage' => $perPage,
                'total' => $total,
                'lastPage' => $lastPage,
            ],
        ]);
    }
    public function exportCsv(Request $request)
    {
        $this->ensureAdmin();
        $range = trim((string)$request->get('range', ''));
        $departemenId = $request->get('departemen', '');
        $q = trim((string)$request->get('q', ''));

        $start = now()->startOfMonth()->toDateString();
        $end = now()->endOfMonth()->toDateString();

        if ($range !== '' && str_contains($range, '-')) {
            $parts = array_map('trim', explode('-', $range));
            if (count($parts) >= 2) {
                $tryStart = trim($parts[0]);
                $tryEnd = trim(implode('-', array_slice($parts, 1)));

                try {
                    $start = Carbon::parse($tryStart)->toDateString();
                    $end = Carbon::parse($tryEnd)->toDateString();
                } catch (\Throwable $e) {
                }
            }
        }

        $absensiQuery = DB::table('absensi')
            ->join('pengguna', 'pengguna.id', '=', 'absensi.id_pengguna')
            ->leftJoin('departemen', 'departemen.id', '=', 'pengguna.id_departemen')
            ->whereBetween('absensi.tanggal', [$start, $end]);

        if ($departemenId !== '' && is_numeric($departemenId)) {
            $absensiQuery->where('pengguna.id_departemen', (int)$departemenId);
        }

        if ($q !== '') {
            $absensiQuery->where(function ($s) use ($q) {
                $s->where('pengguna.nama_lengkap', 'like', '%' . $q . '%')
                    ->orWhere('pengguna.nip', 'like', '%' . $q . '%');
            });
        }

        $absensiRows = $absensiQuery
            ->select([
                'pengguna.nama_lengkap as nama',
                'pengguna.nip as nip',
                'departemen.nama_departemen as departemen',
                'absensi.tanggal as tanggal',
                'absensi.waktu_masuk as waktu_masuk',
                'absensi.waktu_pulang as waktu_pulang',
                'absensi.status as status',
            ])
            ->orderBy('absensi.tanggal', 'desc')
            ->get()
            ->map(function ($r) {
                return [
                    'Nama' => $r->nama,
                    'NIP' => $r->nip,
                    'Tanggal' => Carbon::parse($r->tanggal)->format('Y-m-d'),
                    'Masuk' => ($r->waktu_masuk && $r->waktu_masuk != '0000-00-00 00:00:00') ? Carbon::parse($r->waktu_masuk)->format('H:i') : '',
                    'Keluar' => ($r->waktu_pulang && $r->waktu_pulang != '0000-00-00 00:00:00') ? Carbon::parse($r->waktu_pulang)->format('H:i') : '',
                    'Departemen' => $r->departemen ?: '',
                    'Status' => ($r->status === 'terlambat') ? 'Terlambat' : 'Tepat Waktu',
                ];
            });

        $cutiQuery = PengajuanCuti::join('pengguna', 'pengguna.id', '=', 'pengajuan_cuti.id_pengguna')
            ->leftJoin('departemen', 'departemen.id', '=', 'pengguna.id_departemen')
            ->where('pengajuan_cuti.status_pengajuan', 'disetujui')
            ->whereDate('pengajuan_cuti.tanggal_mulai', '<=', $end)
            ->whereDate('pengajuan_cuti.tanggal_selesai', '>=', $start);

        if ($departemenId !== '' && is_numeric($departemenId)) {
            $cutiQuery->where('pengguna.id_departemen', (int)$departemenId);
        }

        if ($q !== '') {
            $cutiQuery->where(function ($s) use ($q) {
                $s->where('pengguna.nama_lengkap', 'like', '%' . $q . '%')
                    ->orWhere('pengguna.nip', 'like', '%' . $q . '%');
            });
        }

        $cutiRowsRaw = $cutiQuery->select([
            'pengguna.nama_lengkap as nama',
            'pengguna.nip as nip',
            'departemen.nama_departemen as departemen',
            'pengajuan_cuti.tanggal_mulai as tanggal_mulai',
            'pengajuan_cuti.tanggal_selesai as tanggal_selesai',
        ])->get();

        $cutiRows = collect();
        foreach ($cutiRowsRaw as $c) {
            $mulai = Carbon::parse($c->tanggal_mulai)->startOfDay();
            $selesai = Carbon::parse($c->tanggal_selesai)->startOfDay();

            $rangeStart = Carbon::parse($start)->startOfDay();
            $rangeEnd = Carbon::parse($end)->startOfDay();

            if ($mulai->lt($rangeStart)) $mulai = $rangeStart->copy();
            if ($selesai->gt($rangeEnd)) $selesai = $rangeEnd->copy();

            for ($d = $mulai->copy(); $d->lte($selesai); $d->addDay()) {
                $cutiRows->push([
                    'Nama' => $c->nama,
                    'NIP' => $c->nip,
                    'Tanggal' => $d->format('Y-m-d'),
                    'Masuk' => '',
                    'Keluar' => '',
                    'Departemen' => $c->departemen ?: '',
                    'Status' => 'Cuti',
                ]);
            }
        }
        $merged = collect()
            ->concat($absensiRows)
            ->concat($cutiRows)
            ->groupBy(function ($row) {
                return $row['NIP'] . '|' . $row['Tanggal'];
            })
            ->map(function ($items) {
                $cuti = $items->firstWhere('Status', 'Cuti');
                return $cuti ? $cuti : $items->first();
            })
            ->values()
            ->sortByDesc('Tanggal')
            ->values();

        $filename = 'riwayat-absensi-' . $start . '-sd-' . $end . '.csv';

        return new StreamedResponse(function () use ($merged) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Nama', 'NIP', 'Tanggal', 'Masuk', 'Keluar', 'Departemen', 'Status']);

            foreach ($merged as $row) {
                fputcsv($out, [
                    $row['Nama'],
                    $row['NIP'],
                    $row['Tanggal'],
                    $row['Masuk'],
                    $row['Keluar'],
                    $row['Departemen'],
                    $row['Status'],
                ]);
            }
            fclose($out);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
    public function show($id)
    {
        $this->ensureAdmin();

        $row = DB::table('absensi')
            ->join('pengguna', 'pengguna.id', '=', 'absensi.id_pengguna')
            ->leftJoin('departemen', 'departemen.id', '=', 'pengguna.id_departemen')
            ->leftJoin('jabatan', 'jabatan.id', '=', 'pengguna.id_jabatan')
            ->leftJoin('jam_kerja', 'jam_kerja.id', '=', 'absensi.id_jam_kerja')
            ->where('absensi.id', (int)$id)
            ->select([
                'absensi.*',
                'pengguna.nama_lengkap as nama_lengkap',
                'pengguna.nip as nip',
                'departemen.nama_departemen as departemen',
                'jabatan.nama_jabatan as jabatan',
                'jam_kerja.nama_shift as nama_shift',
                'jam_kerja.jam_masuk as shift_masuk',
                'jam_kerja.jam_pulang as shift_pulang',
            ])
            ->first();

        if (!$row) {
            abort(404, 'Data absensi tidak ditemukan.');
        }

        return view('admin.riwayat_absensi.show', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $this->ensureAdmin();

        $request->validate([
            'status' => 'required|in:hadir,terlambat',
            'waktu_masuk' => 'nullable|date',
            'waktu_pulang' => 'nullable|date|after_or_equal:waktu_masuk',
            'bukti_foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'catatan' => 'nullable|string|max:2000',
        ]);

        $absen = DB::table('absensi')->where('id', (int)$id)->first();
        if (!$absen) abort(404, 'Data absensi tidak ditemukan.');

        $dataUpdate = [
            'status' => $request->status,
            'waktu_masuk' => $request->waktu_masuk ? Carbon::parse($request->waktu_masuk) : $absen->waktu_masuk,
            'waktu_pulang' => $request->waktu_pulang ? Carbon::parse($request->waktu_pulang) : $absen->waktu_pulang,
            'catatan' => $request->catatan,
            'diubah_pada' => now(),
        ];

        DB::table('absensi')->where('id', (int)$id)->update($dataUpdate);

        return redirect()
            ->route('admin.riwayat_absensi.show', $id)
            ->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->ensureAdmin();

        $absen = DB::table('absensi')->where('id', (int)$id)->first();
        if (!$absen) abort(404, 'Data absensi tidak ditemukan.');

        DB::table('absensi')->where('id', (int)$id)->delete();

        return redirect()
            ->route('admin.riwayat_absensi')
            ->with('success', 'Data absensi berhasil dihapus.');
    }
}
