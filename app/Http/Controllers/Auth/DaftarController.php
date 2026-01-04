<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Departemen;
use App\Models\Jabatan;

class DaftarController extends Controller
{
    public function formDaftar()
    {
        $departemen = Departemen::where('status_aktif', 1)->orderBy('nama_departemen')->get();
        $jabatan = Jabatan::where('status_aktif', 1)->orderBy('nama_jabatan')->get();

        return view('auth.daftar', compact('departemen', 'jabatan'));
    }

    public function prosesDaftar(Request $request)
    {
        $request->validate([
            'nip' => ['required', 'max:30', 'unique:pengguna,nip'],
            'nama_lengkap' => ['required', 'max:100'],
            'email' => ['nullable', 'email', 'max:100', 'unique:pengguna,email'],
            'kata_sandi' => ['required', 'min:6', 'confirmed'],
            'id_departemen' => ['required', 'integer'],
            'id_jabatan' => ['required', 'integer'],
            'jenis_kelamin' => ['required', 'in:L,P'],
        ]);

        Pengguna::create([
            'nip' => $request->nip,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'kata_sandi' => Hash::make($request->kata_sandi),
            'role' => 'karyawan',
            'status_aktif' => 1,
            'id_departemen' => $request->id_departemen,
            'id_jabatan' => $request->id_jabatan,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('masuk')->with('success', 'Pendaftaran berhasil. Silakan masuk.');
    }
}
