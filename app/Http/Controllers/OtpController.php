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
        $request->validate(['email' => 'required|email|exists:pengguna,email']);
        
        $user = Pengguna::where('email', $request->email)->first();
        $otp = rand(100000, 999999);
        
        Session::put('otp_code', $otp);
        Session::put('otp_email', $request->email);
        Session::put('otp_expires', now()->addMinutes(5));
        
        // Show OTP in notification for development
        return response()->json([
            'success' => true, 
            'message' => 'Kode OTP Anda adalah: ' . $otp,
            'otp' => $otp,
            'show_notification' => true
        ]);
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
}