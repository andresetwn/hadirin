<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class PengaturanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.pengaturan.index', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:120',
            'email' => 'required|email|unique:pengguna,email,' . $user->id,
        ]);
        $pengguna = Pengguna::find($user->id);
        $pengguna->update([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->password_lama, $user->kata_sandi)) {
            return back()->withErrors(['password_lama' => 'Password saat ini salah.']);
        }
        $pengguna = Pengguna::find($user->id);
        $pengguna->update([
            'kata_sandi' => Hash::make($request->password_baru)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }
    public function updateBahasa(Request $request)
    {
        $request->validate([
            'locale' => 'required|in:id,en'
        ]);
        session(['locale' => $request->locale]);

        return redirect()->back()->with('success', 'Bahasa berhasil diubah.');
    }
}
