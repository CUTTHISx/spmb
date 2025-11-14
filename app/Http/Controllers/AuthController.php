<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // ...existing code...
    public function loginPage() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $user = Pengguna::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            return back()->with('error', 'Email atau password salah')->withInput();
        }

        session()->regenerate();
        session(['user' => $user, 'user_id' => $user->id]);

        return match ($user->role) {
            'admin'          => redirect('/dashboard/admin')->with('success', 'Selamat datang, Admin!'),
            'kepsek'         => redirect('/dashboard/kepsek')->with('success', 'Selamat datang, Kepala Sekolah!'),
            'keuangan'       => redirect('/dashboard/keuangan')->with('success', 'Selamat datang, Staff Keuangan!'),
            'verifikator_adm' => redirect('/dashboard/verifikator_adm')->with('success', 'Selamat datang, Verifikator!'),
            'pendaftar'      => redirect('/dashboard/pendaftar')->with('success', 'Selamat datang! Silakan lengkapi data pendaftaran Anda.'),
            default          => redirect('/login')->with('error', 'Role tidak dikenali'),
        };
    }

    public function logout() {
        session()->forget('user');
        return redirect('/')->with('success', 'Anda telah berhasil logout');
    }
    // ...existing code...
}