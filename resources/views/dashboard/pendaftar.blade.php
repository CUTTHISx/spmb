@extends('layouts.main')

@section('title', 'Dashboard Pendaftar - PPDB Online')

@section('content')
@php
    $user = Auth::user();
    $pendaftar = null;
    if ($user) {
        $pendaftar = App\Models\Pendaftar::with(['dataSiswa', 'dataOrtu', 'asalSekolah', 'jurusan', 'berkas'])->where('user_id', $user->id)->first();
    }
    $progress = 0;
    if ($pendaftar) {
        // Step 1: Data lengkap (16.67%)
        if ($pendaftar->dataSiswa && $pendaftar->dataOrtu && $pendaftar->asalSekolah) $progress += 16.67;
        // Step 2: Submit (16.67%)
        if ($pendaftar->status != 'DRAFT') $progress += 16.67;
        // Step 3: Upload berkas (16.67%)
        if ($pendaftar->berkas && $pendaftar->berkas->count() > 0) $progress += 16.67;
        // Step 4: Verifikasi Keuangan (16.67%)
        if ($pendaftar->status_payment == 'VERIFIED') $progress += 16.67;
        // Step 5: Verifikasi Verifikator (16.67%)
        if ($pendaftar->status_berkas == 'VERIFIED' && $pendaftar->status_data == 'VERIFIED') $progress += 16.67;
        // Step 6: Pengumuman (16.67%)
        if (in_array($pendaftar->status, ['ACCEPTED', 'REJECTED'])) $progress += 16.67;
    }
    $progress = round($progress);
@endphp

<div class="container mt-4">
    <!-- Welcome Header -->
    <div class="card system-status-card mb-4">
        <div class="card-body bg-gradient text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
                    <p class="mb-0 opacity-75">Kelola pendaftaran PPDB Anda dengan mudah</p>
                </div>
                <div class="d-none d-md-block">
                    <i class="fas fa-user-graduate fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="status-icon bg-primary mb-3">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                    <h5 class="text-primary">Status</h5>
                    <p class="mb-0">
                        @if($pendaftar)
                            <span class="badge bg-{{ $pendaftar->status == 'DRAFT' ? 'warning' : ($pendaftar->status == 'SUBMITTED' ? 'info' : 'success') }}">
                                {{ $pendaftar->status == 'DRAFT' ? 'Draft' : ($pendaftar->status == 'SUBMITTED' ? 'Dikirim' : 'Diverifikasi') }}
                            </span>
                        @else
                            <span class="badge bg-secondary">Belum Daftar</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="status-icon bg-success mb-3">
                        <i class="fas fa-tasks text-white"></i>
                    </div>
                    <h5 class="text-success">Progress</h5>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                    </div>
                    <small class="text-muted">{{ $progress }}% Selesai</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="status-icon bg-warning mb-3">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                    <h5 class="text-warning">Jurusan</h5>
                    <p class="mb-0">
                        @if($pendaftar && $pendaftar->jurusan)
                            {{ $pendaftar->jurusan->nama }}
                        @else
                            Belum Dipilih
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="status-icon bg-info mb-3">
                        <i class="fas fa-id-card text-white"></i>
                    </div>
                    <h5 class="text-info">No. Daftar</h5>
                    <p class="mb-0">
                        @if($pendaftar && $pendaftar->no_pendaftaran)
                            <code>{{ $pendaftar->no_pendaftaran }}</code>
                        @else
                            <span class="text-muted">Belum Ada</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-list-check me-2 text-primary"></i>Langkah Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $pendaftar && $pendaftar->dataSiswa && $pendaftar->dataOrtu && $pendaftar->asalSekolah ? 'list-group-item-success' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ $pendaftar && $pendaftar->dataSiswa && $pendaftar->dataOrtu && $pendaftar->asalSekolah ? 'bg-success' : 'bg-secondary' }} me-3">
                                    <i class="fas fa-{{ $pendaftar && $pendaftar->dataSiswa && $pendaftar->dataOrtu && $pendaftar->asalSekolah ? 'check' : 'user' }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">1. Isi Data Pendaftaran</h6>
                                    <small class="text-muted">Lengkapi formulir pendaftaran</small>
                                </div>
                            </div>
                            @if($pendaftar && $pendaftar->dataSiswa && $pendaftar->dataOrtu && $pendaftar->asalSekolah)
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <a href="/pendaftaran" class="btn btn-primary btn-sm">Mulai</a>
                            @endif
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $pendaftar && $pendaftar->status != 'DRAFT' ? 'list-group-item-success' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ $pendaftar && $pendaftar->status != 'DRAFT' ? 'bg-success' : 'bg-secondary' }} me-3">
                                    <i class="fas fa-{{ $pendaftar && $pendaftar->status != 'DRAFT' ? 'check' : 'paper-plane' }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">2. Submit Pendaftaran</h6>
                                    <small class="text-muted">Kirim data untuk diverifikasi</small>
                                </div>
                            </div>
                            @if($pendaftar && $pendaftar->status != 'DRAFT')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($pendaftar)
                                <button class="btn btn-warning btn-sm">Submit</button>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $pendaftar && $pendaftar->berkas && $pendaftar->berkas->count() > 0 ? 'list-group-item-success' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ $pendaftar && $pendaftar->berkas && $pendaftar->berkas->count() > 0 ? 'bg-success' : 'bg-secondary' }} me-3">
                                    <i class="fas fa-{{ $pendaftar && $pendaftar->berkas && $pendaftar->berkas->count() > 0 ? 'check' : 'file-upload' }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">3. Upload Berkas</h6>
                                    <small class="text-muted">Upload dokumen pendukung</small>
                                </div>
                            </div>
                            @if($pendaftar && $pendaftar->berkas && $pendaftar->berkas->count() > 0)
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $pendaftar && $pendaftar->status_payment == 'VERIFIED' ? 'list-group-item-success' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ $pendaftar && $pendaftar->status_payment == 'VERIFIED' ? 'bg-success' : 'bg-secondary' }} me-3">
                                    <i class="fas fa-{{ $pendaftar && $pendaftar->status_payment == 'VERIFIED' ? 'check' : 'money-bill' }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">4. Verifikasi Keuangan</h6>
                                    <small class="text-muted">Verifikasi pembayaran</small>
                                </div>
                            </div>
                            @if($pendaftar && $pendaftar->status_payment == 'VERIFIED')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($pendaftar && $pendaftar->status_payment == 'REJECTED')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $pendaftar && $pendaftar->status_berkas == 'VERIFIED' && $pendaftar->status_data == 'VERIFIED' ? 'list-group-item-success' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ $pendaftar && $pendaftar->status_berkas == 'VERIFIED' && $pendaftar->status_data == 'VERIFIED' ? 'bg-success' : 'bg-secondary' }} me-3">
                                    <i class="fas fa-{{ $pendaftar && $pendaftar->status_berkas == 'VERIFIED' && $pendaftar->status_data == 'VERIFIED' ? 'check' : 'clipboard-check' }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">5. Verifikasi Verifikator</h6>
                                    <small class="text-muted">Verifikasi berkas dan data</small>
                                </div>
                            </div>
                            @if($pendaftar && $pendaftar->status_berkas == 'VERIFIED' && $pendaftar->status_data == 'VERIFIED')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($pendaftar && ($pendaftar->status_berkas == 'REJECTED' || $pendaftar->status_data == 'REJECTED'))
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="step-icon bg-secondary me-3">
                                    <i class="fas fa-trophy text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">6. Pengumuman</h6>
                                    <small class="text-muted">Hasil seleksi penerimaan</small>
                                </div>
                            </div>
                            <span class="badge bg-secondary">Menunggu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2 text-warning"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    @if(!$pendaftar)
                        <a href="/pendaftaran" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-plus me-2"></i>Mulai Pendaftaran
                        </a>
                    @else
                        <a href="/pendaftaran" class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-edit me-2"></i>Edit Data
                        </a>
                    @endif
                    
                    <button class="btn btn-outline-secondary w-100 mb-2" disabled>
                        <i class="fas fa-file-upload me-2"></i>Upload Berkas
                    </button>
                    
                    <button class="btn btn-outline-secondary w-100" disabled>
                        <i class="fas fa-search me-2"></i>Cek Status
                    </button>
                </div>
            </div>
            
            <!-- Info Card -->
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Penting</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-calendar text-danger me-2"></i>Batas: <strong>31 Des 2024</strong></li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Pastikan data benar</li>
                        <li class="mb-2"><i class="fas fa-save text-info me-2"></i>Simpan no. pendaftaran</li>
                        <li><i class="fas fa-phone text-primary me-2"></i>Hubungi admin jika ada masalah</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.status-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.step-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection