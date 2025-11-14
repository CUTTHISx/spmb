<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode OTP - PPDB Online</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { color: #4361ee; font-size: 24px; font-weight: bold; }
        .otp-code { background: #4361ee; color: white; padding: 15px 30px; font-size: 32px; font-weight: bold; text-align: center; border-radius: 8px; margin: 20px 0; letter-spacing: 5px; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🎓 PPDB Online</div>
            <h2>Kode Verifikasi OTP</h2>
        </div>
        
        <p>Halo,</p>
        
        <p>Gunakan kode OTP berikut untuk melanjutkan proses login Anda:</p>
        
        <div class="otp-code">{{ $otp }}</div>
        
        <p><strong>Penting:</strong></p>
        <ul>
            <li>Kode OTP ini berlaku selama <strong>5 menit</strong></li>
            <li>Jangan bagikan kode ini kepada siapa pun</li>
            <li>Jika Anda tidak meminta kode ini, abaikan email ini</li>
        </ul>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis dari sistem PPDB Online.<br>
            Jika ada pertanyaan, hubungi admin di admin@ppdb.com</p>
        </div>
    </div>
</body>
</html>