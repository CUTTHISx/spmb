<div class="mb-3">
    <label class="form-label fw-bold">Nama Lengkap</label>
    <p class="form-control-plaintext">{{ $user->nama ?? $user->name }}</p>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Email</label>
    <p class="form-control-plaintext">{{ $user->email }}</p>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Sebagai</label>
    <p class="form-control-plaintext">
        <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
    </p>
</div>
