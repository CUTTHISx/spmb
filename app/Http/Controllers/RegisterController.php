<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'hp' => 'required|string|max:15|unique:pengguna,hp',
            'password' => 'required|min:6|confirmed',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'hp.required' => 'Nomor HP wajib diisi',
            'hp.unique' => 'Nomor HP sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'hp' => $request->hp,
            'password_hash' => Hash::make($request->password),
            'role' => 'pendaftar',
            'status' => 'pending',
            'verification_token' => Str::random(60),
        ]);

        // Simulasi kirim email verifikasi
        // Mail::to($user->email)->send(new VerificationMail($user));

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login untuk melanjutkan.');
    }
}