<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PPDB Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #4F46E5;
            color: #333333;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .left-section {
            flex: 1;
            padding: 40px;
            background-color: #4F46E5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #ffffff;
        }
        
        .right-section {
            flex: 1;
            padding: 40px;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #ffffff;
        }
        
        h2 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #f0f0f0;
        }
        
        .description {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 40px;
            color: #e8e8e8;
        }
        
        hr {
            border: none;
            height: 1px;
            background-color: rgba(255, 255, 255, 0.3);
            margin: 40px 0;
        }
        
        .testimonial {
            font-style: italic;
            line-height: 1.6;
            margin-bottom: 20px;
            color: #ffffff;
        }
        
        .testimonial-author {
            font-weight: 600;
            margin-bottom: 5px;
            color: #ffffff;
        }
        
        .testimonial-role {
            color: #e0e0e0;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333333;
        }
        
        input {
            width: 100%;
            background-color: #f8f9fa;
            padding: 12px 15px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            color: #333333;
            font-size: 15px;
            transition: border-color 0.2s;
        }
        
        input:focus {
            outline: none;
            border-color: #4F46E5;
            background-color: #ffffff;
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            color: white;
        }
        
        .alert-success {
            background-color: #10b981;
        }
        
        .alert-danger {
            background-color: #ef4444;
        }
        
        .error {
            color: #ef4444;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .btn-register {
            background-color: #4F46E5;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            width: 100%;
        }
        
        .btn-register:hover {
            background-color: #4338CA;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.4);
        }
        
        .links {
            text-align: center;
            margin-top: 20px;
            color: #666666;
        }
        
        .links a {
            color: #4F46E5;
            text-decoration: none;
            font-weight: 500;
        }
        
        .links a:hover {
            text-decoration: underline;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .checkbox-group input {
            width: auto;
            margin-right: 8px;
        }
        
        .checkbox-group label {
            margin-bottom: 0;
            color: #666666;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .left-section, .right-section {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-section">
            <h1>Daftar Akun Baru</h1>
            <h2>Buat akun PPDB Online Anda</h2>
            
            <p class="description">
                Bergabunglah dengan sistem PPDB Online kami.<br>
                Proses registrasi cepat dan mudah, hanya membutuhkan waktu beberapa menit saja.
            </p>
            
            <hr>
            
            <p class="testimonial">
                Pendaftaran sangat mudah dan cepat. Dalam hitungan menit, akun saya sudah aktif dan saya bisa langsung melanjutkan proses pendaftaran siswa baru.
            </p>
            
            <div class="testimonial-author">Siti Nurhaliza</div>
            <div class="testimonial-role">Calon Siswa Baru</div>
        </div>
        
        <div class="right-section">
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda" required autofocus>
                    @error('name')
                        <div class="error">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email aktif Anda" required>
                    @error('email')
                        <div class="error">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter" required>
                    @error('password')
                        <div class="error">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password Anda" required>
                    @error('password_confirmation')
                        <div class="error">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="terms" required>
                    <label for="terms">Saya setuju dengan syarat dan ketentuan yang berlaku</label>
                </div>
                
                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i> Daftar Akun
                </button>
                
                <div class="links">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a>
                    <br><br>
                    <a href="/">
                        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
