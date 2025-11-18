<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Services\OtpService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function showOtpForm(): View
    {
        if (!session('registration_data')) {
            return redirect()->route('register')->with('error', 'Silakan isi form registrasi terlebih dahulu.');
        }
        
        return view('auth.register-otp');
    }

    public function completeRegistration(Request $request): RedirectResponse
    {
        $registrationData = session('registration_data');
        
        if (!$registrationData) {
            return redirect()->route('register')->with('error', 'Data registrasi tidak ditemukan. Silakan daftar ulang.');
        }

        try {
            // Create user after OTP verification
            $user = Pengguna::create([
                'nama' => $registrationData['name'],
                'email' => $registrationData['email'],
                'password_hash' => Hash::make($registrationData['password']),
                'role' => 'pendaftar',
            ]);

            // Clear registration session
            session()->forget(['registration_data', 'registration_step']);

            event(new Registered($user));

            return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login untuk melanjutkan.');
        } catch (\Exception $e) {
            return redirect()->route('register')->withErrors(['email' => 'Terjadi kesalahan saat membuat akun. Silakan coba lagi.']);
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:pengguna,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // Store registration data in session for OTP verification
        session([
            'registration_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ],
            'registration_step' => 'otp_verification'
        ]);

        return redirect('/register/otp')->with('success', 'Data registrasi tersimpan. Silakan verifikasi dengan OTP untuk menyelesaikan pendaftaran.');
    }


}