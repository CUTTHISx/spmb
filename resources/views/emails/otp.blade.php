<!DOCTYPE html>
<html>
<head>
    <title>OTP Login - PPDB Online</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .otp-code {
            background: #fff;
            border: 2px dashed #4361ee;
            padding: 20px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #4361ee;
            margin: 20px 0;
            border-radius: 10px;
            letter-spacing: 5px;
        }
        .alert {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎓 SMK Bakti Nusantara 666</h1>
        <p>Kode Verifikasi Login</p>
    </div>
    
    <div class="content">
        <h2>Halo {{ $user_name }}!</h2>
        
        <p>Kami menerima permintaan login ke akun PPDB Online Anda. Gunakan kode OTP berikut untuk melanjutkan:</p>
        
        <div class="otp-code">
            {{ $otp }}
        </div>
        
        <div class="alert">
            <strong>⚠️ Penting:</strong><br>
            • Kode berlaku hingga {{ $expires_at }} WIB<br>
            • Jangan bagikan kode ini kepada siapa pun<br>
            • Kode akan kedaluwarsa dalam 5 menit<br>
            • Jika Anda tidak meminta kode ini, abaikan email ini
        </div>
        
        <p>Masukkan kode OTP di atas pada halaman login untuk mengakses akun Anda.</p>
        
        <p>Terima kasih,<br>
        <strong>Tim PPDB Online</strong></p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim secara otomatis dari sistem PPDB Online.</p>
        <p>&copy; 2024 PPDB Online. All rights reserved.</p>
    </div>
</body>
</html>