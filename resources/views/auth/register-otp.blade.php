@extends('layouts.guest')

@section('content')
<div class="text-center mb-4">
    <div class="otp-icon mb-3">
        <i class="fas fa-user-check fa-4x text-success"></i>
    </div>
    <h4 class="fw-bold text-dark mb-1">Verifikasi Registrasi</h4>
    <p class="text-muted">Verifikasi email untuk menyelesaikan pendaftaran</p>
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

<!-- Registration Info -->
<div class="alert alert-info border-0 shadow-sm mb-4">
    <h6 class="mb-2"><i class="fas fa-info-circle me-2"></i>Data Registrasi</h6>
    <p class="mb-1"><strong>Nama:</strong> {{ session('registration_data.name') }}</p>
    <p class="mb-0"><strong>Email:</strong> {{ session('registration_data.email') }}</p>
</div>

<!-- Loading State -->
<div id="loadingState" class="text-center">
    <div class="spinner-border text-success mb-3" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <p class="text-muted">Mengirim kode verifikasi...</p>
</div>

<!-- OTP Form -->
<div id="otpForm" class="otp-form" style="display: none;">
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="fas fa-info-circle me-2"></i>
        <span id="otpMessage">Kode verifikasi telah dikirim ke admin (mannzrx@gmail.com).</span>
    </div>

    <form id="verifyOtpForm">
        @csrf
        <div class="mb-4">
            <label for="otp" class="form-label fw-medium text-dark">
                <i class="fas fa-key me-2 text-success"></i>Kode Verifikasi
            </label>
            <input id="otp" class="form-control form-control-lg border-0 shadow-sm text-center" 
                   type="text" name="otp" placeholder="000000" maxlength="6" required autofocus>
            <div id="otpError" class="text-danger small mt-2" style="display: none;"></div>
        </div>

        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-primary btn-lg shadow-sm" id="verifyOtpBtn">
                <i class="fas fa-check-circle me-2"></i>Verifikasi & Buat Akun
            </button>
        </div>

        <div class="text-center">
            <button type="button" class="btn btn-outline-secondary" onclick="resendOtp()">
                <i class="fas fa-redo me-2"></i>Kirim Ulang Kode
            </button>
        </div>
    </form>
</div>

<!-- Back to Register -->
<div class="text-center">
    <a href="{{ route('register') }}" class="text-decoration-none text-success">
        <i class="fas fa-arrow-left me-1"></i>Kembali ke Form Registrasi
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
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
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

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
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
// Auto-send OTP when page loads
document.addEventListener('DOMContentLoaded', function() {
    sendOtpAutomatically();
});

function sendOtpAutomatically() {
    const email = '{{ session("registration_data.email") }}';
    
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
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('otpForm').style.display = 'block';
        
        if (data.success) {
            if (data.show_notification && data.otp) {
                document.getElementById('otpMessage').innerHTML = 
                    '<strong>Kode OTP:</strong> <span class="badge bg-success fs-6">' + data.otp + '</span><br><small class="text-muted">Email juga dikirim ke mannzrx@gmail.com</small>';
            }
            // Focus on OTP input
            document.getElementById('otp').focus();
        } else {
            document.getElementById('otpMessage').innerHTML = 
                '<span class="text-danger">Gagal mengirim OTP: ' + data.message + '</span>';
        }
    })
    .catch(error => {
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('otpForm').style.display = 'block';
        document.getElementById('otpMessage').innerHTML = 
            '<span class="text-danger">Terjadi kesalahan saat mengirim OTP</span>';
    });
}

document.getElementById('verifyOtpForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const otp = document.getElementById('otp').value;
    const btn = document.getElementById('verifyOtpBtn');
    const originalText = btn.innerHTML;
    
    // Disable button and show loading
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memverifikasi...';
    
    fetch('/verify-registration-otp', {
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

function resendOtp() {
    document.getElementById('otpForm').style.display = 'none';
    document.getElementById('loadingState').style.display = 'block';
    document.getElementById('otp').value = '';
    document.getElementById('otpError').style.display = 'none';
    
    // Send OTP again
    setTimeout(() => {
        sendOtpAutomatically();
    }, 1000);
}

// Auto-format OTP input
document.getElementById('otp').addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '');
});
</script>
@endsection