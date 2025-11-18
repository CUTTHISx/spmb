@extends('layouts.guest')

@section('content')
<div class="text-center mb-4">
    <div class="login-icon mb-3">
        <i class="fas fa-user-circle fa-4x text-primary"></i>
    </div>
    <h4 class="fw-bold text-dark mb-1">Selamat Datang</h4>
    <p class="text-muted">Masuk ke akun PPDB Online Anda</p>
</div>

@if (session('status'))
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="login-form">
    @csrf

    <!-- Email Address -->
    <div class="mb-4">
        <label for="email" class="form-label fw-medium text-dark">
            <i class="fas fa-envelope me-2 text-primary"></i>Email
        </label>
        <input id="email" class="form-control form-control-lg border-0 shadow-sm" 
               type="email" name="email" value="{{ old('email') }}" 
               placeholder="Masukkan email Anda" required autofocus autocomplete="username">
        @error('email')
            <div class="text-danger small mt-2">
                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
            </div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-4">
        <label for="password" class="form-label fw-medium text-dark">
            <i class="fas fa-lock me-2 text-primary"></i>Password
        </label>
        <div class="position-relative">
            <input id="password" class="form-control form-control-lg border-0 shadow-sm" 
                   type="password" name="password" placeholder="Masukkan password Anda" 
                   required autocomplete="current-password">
            <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-3" 
                    onclick="togglePassword()" style="border: none; background: none;">
                <i class="fas fa-eye text-muted" id="toggleIcon"></i>
            </button>
        </div>
        @error('password')
            <div class="text-danger small mt-2">
                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
            </div>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="mb-4">
        <div class="form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label class="form-check-label text-muted" for="remember_me">
                Ingat saya selama 30 hari
            </label>
        </div>
    </div>

    <!-- Login Button -->
    <div class="d-grid mb-4">
        <button type="submit" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Dashboard
        </button>
    </div>



    <!-- Back to Home -->
    <div class="text-center mb-3">
        <a href="/" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
        </a>
    </div>

    <!-- Links -->
    <div class="text-center">
        <div class="mb-2">
            @if (Route::has('password.request'))
                <a class="text-decoration-none text-primary" href="{{ route('password.request') }}">
                    <i class="fas fa-key me-1"></i>Lupa password?
                </a>
            @endif
        </div>
        <div>
            <span class="text-muted">Belum punya akun?</span>
            <a class="text-decoration-none text-primary fw-medium" href="{{ route('register') }}">
                Daftar sekarang
            </a>
        </div>
    </div>
</form>

<style>
.login-form {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-control:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

.btn-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(13, 110, 253, 0.3);
}

.btn-outline-success {
    transition: all 0.3s ease;
}

.btn-outline-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(25, 135, 84, 0.3);
}

.login-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
</style>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>
@endsection
