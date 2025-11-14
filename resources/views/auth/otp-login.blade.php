@extends('layouts.guest')

@section('content')
<div class="text-center mb-4">
    <h4>Verifikasi OTP</h4>
    <p class="text-muted">Masukkan email untuk mendapatkan kode OTP</p>
</div>
                    <!-- Email Form -->
                    <form id="emailForm" style="display: block;">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Kirim OTP</button>
                    </form>

                    <!-- OTP Form -->
                    <form id="otpForm" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Kode OTP</label>
                            <input type="text" class="form-control text-center" id="otp" maxlength="6" placeholder="000000" style="font-size: 24px; letter-spacing: 5px;">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Verifikasi OTP</button>
                        <button type="button" class="btn btn-link w-100" onclick="backToEmail()">Kembali</button>
                    </form>


<script>
document.getElementById('emailForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    
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
            // Show notification with OTP
            if (data.otp) {
                showNotification('🔑 Kode OTP Anda: ' + data.otp, 'success');
                // Also show in console for development
                console.log('OTP Code:', data.otp);
            }
            
            // Switch to OTP form
            document.getElementById('emailForm').style.display = 'none';
            document.getElementById('otpForm').style.display = 'block';
            document.getElementById('otp').focus();
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('Terjadi kesalahan', 'error');
    });
});

document.getElementById('otpForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const otp = document.getElementById('otp').value;
    
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
            showNotification(data.message, 'success');
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1000);
        } else {
            showNotification(data.message, 'error');
        }
    });
});

function backToEmail() {
    document.getElementById('otpForm').style.display = 'none';
    document.getElementById('emailForm').style.display = 'block';
    document.getElementById('email').focus();
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed shadow-lg`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 350px; font-size: 16px; font-weight: bold; border-radius: 10px;';
    notification.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <span>${message}</span>
            <button type="button" class="btn-close" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 15 seconds for OTP
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 15000);
}
</script>
@endsection