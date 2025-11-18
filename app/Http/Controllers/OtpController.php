<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        // Check if user exists for login, or allow for registration
        $user = Pengguna::where('email', $request->email)->first();
        
        $otp = rand(100000, 999999);
        
        Session::put('otp_code', $otp);
        Session::put('otp_email', $request->email);
        Session::put('otp_expires', now()->addMinutes(5));
        
        try {
            // Log email attempt
            \Log::info('Attempting to send OTP email', [
                'to' => $request->email,
                'otp' => $otp,
                'user_name' => $user->nama ?? session('registration_data.name') ?? 'User'
            ]);
            
            // Send OTP to user's email
            Mail::to($request->email)->send(new OtpMail([
                'otp' => $otp,
                'user_email' => $request->email,
                'user_name' => $user->nama ?? session('registration_data.name') ?? 'User',
                'expires_at' => now()->addMinutes(5)->format('H:i')
            ]));
            
            \Log::info('OTP email sent successfully', ['to' => $request->email]);
            
            return response()->json([
                'success' => true, 
                'message' => 'OTP dikirim ke ' . $request->email,
                'show_notification' => true
            ]);
        } catch (\Exception $e) {
            // Log the actual error
            \Log::error('Failed to send OTP email', [
                'error' => $e->getMessage(),
                'to' => $request->email,
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            // Return detailed error for debugging
            return response()->json([
                'success' => false, 
                'message' => 'Email gagal dikirim: ' . $e->getMessage(),
                'otp' => $otp, // Show OTP for development
                'show_notification' => true,
                'debug' => [
                    'error' => $e->getMessage(),
                    'mail_config' => [
                        'host' => config('mail.mailers.smtp.host'),
                        'port' => config('mail.mailers.smtp.port'),
                        'username' => config('mail.mailers.smtp.username')
                    ]
                ]
            ]);
        }
    }
    
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);
        
        // Get session data
        $sessionOtp = Session::get('otp_code');
        $sessionEmail = Session::get('otp_email');
        $otpExpires = Session::get('otp_expires');
        
        if (!$sessionOtp || !$sessionEmail || !$otpExpires) {
            return response()->json(['success' => false, 'message' => 'Kode OTP tidak valid']);
        }
        
        if (now()->gt($otpExpires)) {
            Session::forget(['otp_code', 'otp_email', 'otp_expires']);
            return response()->json(['success' => false, 'message' => 'Kode OTP telah kedaluwarsa']);
        }
        
        if ($request->otp != $sessionOtp) {
            return response()->json(['success' => false, 'message' => 'Kode OTP salah']);
        }
        
        // Login existing user
        $user = Pengguna::where('email', $sessionEmail)->first();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan']);
        }
        
        auth()->login($user);
        
        Session::forget(['otp_code', 'otp_email', 'otp_expires']);
        
        $redirectUrl = match($user->role) {
            'admin' => '/dashboard/admin',
            'kepsek' => '/dashboard/kepsek', 
            'keuangan' => '/dashboard/keuangan',
            'verifikator_adm' => '/dashboard/verifikator',
            'verifikator' => '/dashboard/verifikator',
            'pendaftar' => '/dashboard/pendaftar',
            default => '/dashboard'
        };
        
        return response()->json([
            'success' => true, 
            'message' => 'Login berhasil!',
            'redirect' => $redirectUrl
        ]);
    }

    public function verifyRegistrationOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);
        
        // Get session data
        $sessionOtp = Session::get('otp_code');
        $sessionEmail = Session::get('otp_email');
        $otpExpires = Session::get('otp_expires');
        $registrationData = Session::get('registration_data');
        
        if (!$sessionOtp || !$sessionEmail || !$otpExpires || !$registrationData) {
            return response()->json(['success' => false, 'message' => 'Kode OTP tidak valid atau data registrasi tidak ditemukan']);
        }
        
        if (now()->gt($otpExpires)) {
            Session::forget(['otp_code', 'otp_email', 'otp_expires']);
            return response()->json(['success' => false, 'message' => 'Kode OTP telah kedaluwarsa']);
        }
        
        if ($request->otp != $sessionOtp) {
            return response()->json(['success' => false, 'message' => 'Kode OTP salah']);
        }
        
        // Verify email matches registration data
        if ($sessionEmail !== $registrationData['email']) {
            return response()->json(['success' => false, 'message' => 'Email tidak sesuai dengan data registrasi']);
        }
        
        try {
            // Create user after OTP verification
            $user = Pengguna::create([
                'nama' => $registrationData['name'],
                'email' => $registrationData['email'],
                'password_hash' => \Hash::make($registrationData['password']),
                'role' => 'pendaftar',
            ]);

            // Clear all session data
            Session::forget(['otp_code', 'otp_email', 'otp_expires', 'registration_data', 'registration_step']);

            return response()->json([
                'success' => true, 
                'message' => 'Registrasi berhasil! Silakan login.',
                'redirect' => '/login'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal membuat akun. Silakan coba lagi.']);
        }
    }
}