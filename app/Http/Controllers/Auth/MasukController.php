<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasukController extends Controller
{
    public function formMasuk()
    {
        return view('auth.masuk');
    }

    public function prosesMasuk(Request $request)
    {
        $request->validate([
            'nip' => ['required'],
            'kata_sandi' => ['required'],
        ]);

        $kredensial = [
            'nip' => $request->nip,
            'password' => $request->kata_sandi,
            'status_aktif' => 1,
        ];

        if (Auth::attempt($kredensial)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect('/admin');
            }

            return redirect('/beranda');
        }

        return back()->withErrors([
            'nip' => 'NIP atau kata sandi salah',
        ]);
    }

    public function keluar(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/masuk');
    }
}
