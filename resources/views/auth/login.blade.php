<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PPDB Online</title>
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
            margin-bottom: 25px;
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
            background-color: #10b981;
            color: white;
        }
        
        .error {
            color: #ef4444;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .btn-login {
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
        
        .btn-login:hover {
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
            <h1>Selamat Datang</h1>
            <h2>Masuk ke akun PPDB Online</h2>
            
            <p class="description">
                Sistem Penerimaan Peserta Didik Baru Online.<br>
                Proses pendaftaran yang mudah, cepat, dan aman untuk calon siswa baru.
            </p>
            
            <hr>
            
            <p class="testimonial">
                Sistem PPDB Online sangat memudahkan proses pendaftaran. Interface yang user-friendly dan proses yang cepat membuat pengalaman pendaftaran menjadi menyenangkan.
            </p>
            
            <div class="testimonial-author">Ahmad Rizki</div>
            <div class="testimonial-role">Orang Tua Siswa</div>
        </div>
        
        <div class="right-section">
            @if (session('status'))
                <div class="alert">
                    <i class="fas fa-check-circle"></i> {{ session('status') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email Anda" required autofocus>
                    @error('email')
                        <div class="error">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan password Anda" required>
                    @error('password')
                        <div class="error">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="remember_me" name="remember">
                    <label for="remember_me">Ingat saya selama 30 hari</label>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Masuk ke Dashboard
                </button>
                
                <div class="links">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            <i class="fas fa-key"></i> Lupa password?
                        </a>
                        <br><br>
                    @endif
                    Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
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
