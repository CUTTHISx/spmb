<?php

namespace App\Services;

use App\Models\Otp;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class OtpService
{
    public static function generate(string $email): string
    {
        // Hapus OTP lama yang belum digunakan
        Otp::where('email', $email)->where('used', false)->delete();
        
        // Generate OTP 6 digit
        $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Simpan ke database dengan expiry 5 menit
        Otp::create([
            'email' => $email,
            'otp' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(5),
            'used' => false
        ]);
        
        // Kirim email
        self::sendOtpEmail($email, $otpCode);
        
        return $otpCode;
    }
    
    public static function verify(string $email, string $otp): bool
    {
        $otpRecord = Otp::where('email', $email)
            ->where('otp', $otp)
            ->where('used', false)
            ->first();
            
        if (!$otpRecord || $otpRecord->isExpired()) {
            return false;
        }
        
        // Mark as used
        $otpRecord->update(['used' => true]);
        
        return true;
    }
    
    private static function sendOtpEmail(string $email, string $otp): void
    {
        Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($email) {
            $message->to($email)
                    ->subject('Kode OTP Pendaftaran PPDB Online');
        });
    }
}