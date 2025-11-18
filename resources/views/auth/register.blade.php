@extends('layouts.guest')

@section('content')
<div class="text-center mb-4">
    <div class="register-icon mb-3">
        <i class="fas fa-user-plus fa-4x text-primary"></i>
    </div>
    <h4 class="fw-bold text-dark mb-1">Daftar Akun Baru</h4>
    <p class="text-muted">Buat akun untuk mendaftar PPDB Online</p>
</div>

@if (session('success'))
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('register') }}" class="register-form">
    @csrf

    <!-- Name -->
    <div class="mb-4">
        <label for="name" class="form-label fw-medium text-dark">
            <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap
        </label>
        <input id="name" class="form-control form-control-lg border-0 shadow-sm" 
               type="text" name="name" value="{{ old('name') }}" 
               placeholder="Masukkan nama lengkap Anda" required autofocus autocomplete="name">
        @error('name')
            <div class="text-danger small mt-2">
                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
            </div>
        @enderror
    </div>

    <!-- Email Address -->
    <div class="mb-4">
        <label for="email" class="form-label fw-medium text-dark">
            <i class="fas fa-envelope me-2 text-primary"></i>Email
        </label>
        <input id="email" class="form-control form-control-lg border-0 shadow-sm" 
               type="email" name="email" value="{{ old('email') }}" 
               placeholder="Masukkan email aktif Anda" required autocomplete="username">
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
                   type="password" name="password" placeholder="Minimal 8 karakter" 
                   required autocomplete="new-password">
            <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-3" 
                    onclick="togglePassword('password', 'toggleIcon1')" style="border: none; background: none;">
                <i class="fas fa-eye text-muted" id="toggleIcon1"></i>
            </button>
        </div>
        @error('password')
            <div class="text-danger small mt-2">
                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
            </div>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-4">
        <label for="password_confirmation" class="form-label fw-medium text-dark">
            <i class="fas fa-lock me-2 text-primary"></i>Konfirmasi Password
        </label>
        <div class="position-relative">
            <input id="password_confirmation" class="form-control form-control-lg border-0 shadow-sm" 
                   type="password" name="password_confirmation" placeholder="Ulangi password Anda" 
                   required autocomplete="new-password">
            <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-3" 
                    onclick="togglePassword('password_confirmation', 'toggleIcon2')" style="border: none; background: none;">
                <i class="fas fa-eye text-muted" id="toggleIcon2"></i>
            </button>
        </div>
        @error('password_confirmation')
            <div class="text-danger small mt-2">
                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
            </div>
        @enderror
    </div>

    <!-- Terms -->
    <div class="mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="terms" required>
            <label class="form-check-label text-muted" for="terms">
                Saya setuju dengan <a href="#" class="text-primary">syarat dan ketentuan</a> yang berlaku
            </label>
        </div>
    </div>

    <!-- Register Button -->
    <div class="d-grid mb-4">
        <button type="submit" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-user-plus me-2"></i>Daftar Akun
        </button>
    </div>

    <!-- Back to Home -->
    <div class="text-center mb-3">
        <a href="/" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
        </a>
    </div>

    <!-- Login Link -->
    <div class="text-center">
        <span class="text-muted">Sudah punya akun?</span>
        <a class="text-decoration-none text-primary fw-medium" href="{{ route('login') }}">
            Masuk sekarang
        </a>
    </div>
</form>

<style>
.register-form {
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

.btn-outline-secondary {
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
}

.register-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
</style>

<script>
function togglePassword(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const toggleIcon = document.getElementById(iconId);
    
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
