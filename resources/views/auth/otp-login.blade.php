@extends('layouts.guest')

@section('content')
<div class="text-center mb-4">
    <div class="otp-icon mb-3">
        <i class="fas fa-shield-alt fa-4x text-info"></i>
    </div>
    <h4 class="fw-bold text-dark mb-1">Login dengan OTP</h4>
    <p class="text-muted">Masukkan email untuk mendapatkan kode OTP</p>
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

<!-- Email Form -->
<div id="emailForm" class="otp-form">
    <form id="sendOtpForm">
        @csrf
        <div class="mb-4">
            <label for="email" class="form-label fw-medium text-dark">
                <i class="fas fa-envelope me-2 text-info"></i>Email
            </label>
            <input id="email" class="form-control form-control-lg border-0 shadow-sm" 
                   type="email" name="email" placeholder="Masukkan email Anda" required>
            <div id="emailError" class="text-danger small mt-2" style="display: none;"></div>
        </div>

        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-info btn-lg shadow-sm" id="sendOtpBtn">
                <i class="fas fa-paper-plane me-2"></i>Kirim Kode OTP
            </button>
        </div>
    </form>
</div>

<!-- OTP Form -->
<div id="otpForm" class="otp-form" style="display: none;">
    <div class="alert alert-info border-0 shadow-sm mb-4">
        <i class="fas fa-info-circle me-2"></i>
        <span id="otpMessage">Kode OTP telah dikirim ke admin. Silakan tunggu konfirmasi.</span>
    </div>

    <form id="verifyOtpForm">
        @csrf
        <div class="mb-4">
            <label for="otp" class="form-label fw-medium text-dark">
                <i class="fas fa-key me-2 text-info"></i>Kode OTP
            </label>
            <input id="otp" class="form-control form-control-lg border-0 shadow-sm text-center" 
                   type="text" name="otp" placeholder="000000" maxlength="6" required>
            <div id="otpError" class="text-danger small mt-2" style="display: none;"></div>
        </div>

        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-success btn-lg shadow-sm" id="verifyOtpBtn">
                <i class="fas fa-sign-in-alt me-2"></i>Verifikasi & Login
            </button>
        </div>

        <div class="text-center">
            <button type="button" class="btn btn-outline-secondary" onclick="backToEmail()">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Email
            </button>
        </div>
    </form>
</div>

<!-- Back to Login -->
<div class="text-center">
    <a href="{{ route('login') }}" class="text-decoration-none text-info">
        <i class="fas fa-arrow-left me-1"></i>Kembali ke Login Normal
    </a>
</div>

<style>
.otp-form {
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
    border-color: #17a2b8;
    box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.15);
}

.btn-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-info:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(23, 162, 184, 0.3);
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
}

.otp-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

#otp {
    font-size: 1.5rem;
    letter-spacing: 0.5rem;
    font-weight: bold;
}
</style>

<script>
document.getElementById('sendOtpForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const btn = document.getElementById('sendOtpBtn');
    const originalText = btn.innerHTML;
    
    // Disable button and show loading
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
    
    fetch('/send-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('emailForm').style.display = 'none';
            document.getElementById('otpForm').style.display = 'block';
            
            if (data.show_notification && data.otp) {
                document.getElementById('otpMessage').innerHTML = 
                    '<strong>Development Mode:</strong> Kode OTP Anda adalah: <strong>' + data.otp + '</strong>';
            }
        } else {
            document.getElementById('emailError').textContent = data.message;
            document.getElementById('emailError').style.display = 'block';
        }
    })
    .catch(error => {
        document.getElementById('emailError').textContent = 'Terjadi kesalahan. Silakan coba lagi.';
        document.getElementById('emailError').style.display = 'block';
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
});

document.getElementById('verifyOtpForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const otp = document.getElementById('otp').value;
    const btn = document.getElementById('verifyOtpBtn');
    const originalText = btn.innerHTML;
    
    // Disable button and show loading
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memverifikasi...';
    
    fetch('/verify-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ otp: otp })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            document.getElementById('otpError').textContent = data.message;
            document.getElementById('otpError').style.display = 'block';
        }
    })
    .catch(error => {
        document.getElementById('otpError').textContent = 'Terjadi kesalahan. Silakan coba lagi.';
        document.getElementById('otpError').style.display = 'block';
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
});

function backToEmail() {
    document.getElementById('otpForm').style.display = 'none';
    document.getElementById('emailForm').style.display = 'block';
    document.getElementById('email').value = '';
    document.getElementById('otp').value = '';
    document.getElementById('emailError').style.display = 'none';
    document.getElementById('otpError').style.display = 'none';
}

// Auto-format OTP input
document.getElementById('otp').addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '');
});
</script>
@endsection