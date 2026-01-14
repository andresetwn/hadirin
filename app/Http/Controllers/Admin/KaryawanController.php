<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\Jabatan;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        // Query data karyawan (bukan admin)
        $query = Pengguna::with(['jabatan', 'departemen']); 

        // Fitur Pencarian
        if ($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $karyawan = $query->paginate(10); 

        return view('admin.karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        $jabatan = Jabatan::all();
        $departemen = Departemen::all();
        return view('admin.karyawan.create', compact('jabatan', 'departemen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:pengguna,nip',
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:pengguna,email',
            'kata_sandi' => 'required|min:6',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        Pengguna::create([
            'nip' => $request->nip,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'kata_sandi' => Hash::make($request->kata_sandi), // Hash password
            'jenis_kelamin' => $request->jenis_kelamin, // 'L' atau 'P'
            'id_jabatan' => $request->id_jabatan,
            'id_departemen' => $request->id_departemen,
            'role' => 'karyawan',
            'status_aktif' => 1,
        ]);

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $karyawan = Pengguna::findOrFail($id);
        $jabatan = Jabatan::all();
        $departemen = Departemen::all();
        return view('admin.karyawan.edit', compact('karyawan', 'jabatan', 'departemen'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = Pengguna::findOrFail($id);

        $request->validate([
            'nip' => 'required|unique:pengguna,nip,'.$id,
            'email' => 'required|email|unique:pengguna,email,'.$id,
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        // Siapkan data update
        $data = [
            'nip' => $request->nip,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'id_jabatan' => $request->id_jabatan,
            'id_departemen' => $request->id_departemen,
        ];

        // Jika password diisi, update password baru
        if($request->filled('kata_sandi')) {
            $data['kata_sandi'] = Hash::make($request->kata_sandi);
        }

        $karyawan->update($data);

        return redirect()->route('admin.karyawan.index')->with('success', 'Data karyawan diperbarui');
    }

    public function destroy($id)
    {
        Pengguna::destroy($id);
        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan dihapus');
    }
}