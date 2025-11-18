@extends('layouts.main')

@section('title', 'Pembayaran - PPDB Online')

@section('content')
<div class="container mt-4">
    @if(!$canPay)
    <!-- Belum Bisa Bayar -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-lock fa-4x text-warning mb-3"></i>
                    <h3 class="fw-bold text-warning">Pembayaran Belum Tersedia</h3>
                    <p class="text-muted mb-4">
                        Anda harus menyelesaikan verifikasi administrasi terlebih dahulu sebelum dapat melakukan pembayaran.
                    </p>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Status Verifikasi:</strong><br>
                        Berkas: <span class="badge bg-{{ $pendaftar->status_berkas == 'VERIFIED' ? 'success' : ($pendaftar->status_berkas == 'REJECTED' ? 'danger' : 'warning') }}">{{ $pendaftar->status_berkas ?? 'PENDING' }}</span><br>
                        Data: <span class="badge bg-{{ $pendaftar->status_data == 'VERIFIED' ? 'success' : ($pendaftar->status_data == 'REJECTED' ? 'danger' : 'warning') }}">{{ $pendaftar->status_data ?? 'PENDING' }}</span>
                    </div>
                    <a href="/dashboard/pendaftar" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Bisa Bayar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-success text-white border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-white bg-opacity-20 rounded-circle p-3">
                                <i class="fas fa-credit-card fa-2x"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">Pembayaran Pendaftaran</h2>
                            <p class="mb-0 opacity-90">Verifikasi administrasi telah lulus, silakan lakukan pembayaran</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Pembayaran -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">Status Pembayaran</h5>
                        <span class="badge bg-{{ $pendaftar->pembayaran ? ($pendaftar->pembayaran->status_verifikasi == 'LUNAS' ? 'success' : ($pendaftar->pembayaran->status_verifikasi == 'DITOLAK' ? 'danger' : 'warning')) : 'secondary' }}">
                            {{ $pendaftar->pembayaran ? ($pendaftar->pembayaran->status_verifikasi == 'LUNAS' ? 'Terbayar' : ($pendaftar->pembayaran->status_verifikasi == 'DITOLAK' ? 'Ditolak' : 'Menunggu Verifikasi')) : 'Belum Bayar' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <p class="text-muted mb-1">Nomor Pendaftaran</p>
                            <p class="fw-bold">{{ $pendaftar->no_pendaftaran }}</p>
                        </div>
                        <div class="col-md-3">
                            <p class="text-muted mb-1">Jurusan Pilihan</p>
                            <p class="fw-bold">{{ $pendaftar->jurusan->nama ?? '-' }}</p>
                        </div>
                        <div class="col-md-3">
                            <p class="text-muted mb-1">Biaya Pendaftaran</p>
                            <p class="fw-bold text-primary fs-4">Rp 250.000</p>
                        </div>
                        <div class="col-md-3">
                            <p class="text-muted mb-1">Batas Waktu</p>
                            <p class="fw-bold text-danger">3 hari setelah verifikasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Instruksi Pembayaran -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Instruksi Pembayaran
                    </h5>
                </div>
                <div class="card-body">
                    <div class="border-start border-primary border-4 ps-3 mb-4">
                        <h6 class="fw-bold mb-2">Transfer Bank</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Bank BCA</strong></p>
                                <p class="mb-1">No. Rekening: <span class="badge bg-light text-dark font-monospace">1234567890</span></p>
                                <p class="mb-1">Atas Nama: <strong>YAYASAN PENDIDIKAN ABC</strong></p>
                                <p class="text-danger fw-bold">Nominal: Rp 250.000</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Penting!</strong>
                        <ul class="mb-0 mt-2">
                            <li>Transfer sesuai nominal yang tertera (Rp 250.000)</li>
                            <li>Simpan bukti transfer untuk diupload</li>
                            <li>Pembayaran maksimal 3 hari setelah verifikasi administrasi lulus</li>
                            <li>Jika lewat batas waktu, pendaftaran akan dibatalkan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Bukti Pembayaran -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-upload text-primary me-2"></i>
                        Upload Bukti Pembayaran
                    </h5>
                </div>
                <div class="card-body">
                    <form action="/pendaftaran/pembayaran" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Bukti Transfer</label>
                                    <div class="border border-2 border-dashed rounded p-4 text-center">
                                        <input type="file" name="bukti_pembayaran" accept="image/*,.pdf" class="d-none" id="bukti-file" required>
                                        <label for="bukti-file" style="cursor: pointer;">
                                            @if($pendaftar->pembayaran && $pendaftar->pembayaran->bukti_pembayaran)
                                                <i class="fas fa-file-check fa-3x text-success mb-2"></i>
                                                <p class="text-success fw-bold">Bukti sudah diupload</p>
                                                <a href="/{{ $pendaftar->pembayaran->bukti_pembayaran }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Bukti</a>
                                            @else
                                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                                <p class="text-muted">Klik untuk upload bukti transfer</p>
                                            @endif
                                            <p class="small text-muted">Format: JPG, PNG, PDF (Max: 2MB)</p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Pengirim</label>
                                    <input type="text" name="nama_pengirim" class="form-control" 
                                           placeholder="Nama yang tertera di rekening pengirim" 
                                           value="{{ $pendaftar->pembayaran->nama_pengirim ?? '' }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Transfer</label>
                                    <input type="date" name="tanggal_transfer" class="form-control" 
                                           value="{{ $pendaftar->pembayaran->tanggal_transfer ?? '' }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Nominal Transfer</label>
                                    <input type="number" name="nominal" class="form-control" 
                                           value="250000" readonly>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Catatan (Opsional)</label>
                                    <textarea name="catatan" class="form-control" rows="3" 
                                              placeholder="Catatan tambahan jika ada">{{ $pendaftar->pembayaran->catatan ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="/dashboard/pendaftar" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-1"></i>
                                {{ $pendaftar->pembayaran ? 'Update' : 'Upload' }} Bukti Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
document.getElementById('bukti-file')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const label = e.target.nextElementSibling;
        label.innerHTML = `
            <i class="fas fa-file-alt fa-3x text-success mb-2"></i>
            <p class="text-success fw-bold">${file.name}</p>
            <p class="small text-muted">Klik untuk ganti file</p>
        `;
    }
});
</script>
@endsection