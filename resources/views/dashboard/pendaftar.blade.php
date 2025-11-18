@extends('layouts.main')

@section('title', 'Dashboard Pendaftar - PPDB Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/layouts/dashboard.css') }}">
@endsection

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
        // Step 2: Upload berkas (16.67%)
        if ($pendaftar->berkas && $pendaftar->berkas->count() > 0) $progress += 16.67;
        // Step 3: Submit (16.67%)
        if ($pendaftar->status != 'DRAFT') $progress += 16.67;
        // Step 4: Verifikasi Admin (16.67%)
        if ($pendaftar->status_berkas == 'VERIFIED' && $pendaftar->status_data == 'VERIFIED') $progress += 16.67;
        // Step 5: Pembayaran (16.67%)
        if ($pendaftar->pembayaran && $pendaftar->pembayaran->bukti_pembayaran) $progress += 16.67;
        // Step 6: Verifikasi Keuangan (16.67%) - Final step = 100%
        if ($pendaftar->pembayaran && $pendaftar->pembayaran->status_verifikasi == 'VERIFIED') $progress += 16.67;
    }
    $progress = round($progress);
@endphp

<div class="container mt-4">
    <!-- Welcome Header -->
    <div class="card system-status-card mb-4">
        <div class="card-body bg-gradient-primary text-white rounded">
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

    <!-- Stats Overview -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold">
                                @if($pendaftar)
                                    {{ $pendaftar->status == 'DRAFT' ? 'Draft' : ($pendaftar->status == 'SUBMITTED' ? 'Dikirim' : 'Diverifikasi') }}
                                @else
                                    Belum Daftar
                                @endif
                            </h3>
                            <p class="text-muted mb-0">Status Pendaftaran</p>
                        </div>
                        <div class="stat-icon bg-primary-light">
                            <i class="fas fa-file-alt text-primary fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-{{ $pendaftar ? ($pendaftar->status == 'DRAFT' ? 'warning' : ($pendaftar->status == 'SUBMITTED' ? 'info' : 'success')) : 'secondary' }}">
                            @if($pendaftar)
                                {{ $pendaftar->status == 'DRAFT' ? 'Perlu Dilengkapi' : ($pendaftar->status == 'SUBMITTED' ? 'Menunggu Verifikasi' : 'Terverifikasi') }}
                            @else
                                Mulai Pendaftaran
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold">{{ $progress }}%</h3>
                            <p class="text-muted mb-0">Progress Pendaftaran</p>
                        </div>
                        <div class="stat-icon bg-success-light">
                            <i class="fas fa-tasks text-success fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                        </div>
                        <small class="text-muted">{{ $progress == 100 ? 'Selesai' : $progress.'% dari 6 langkah' }}</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold">
                                @if($pendaftar && $pendaftar->jurusan)
                                    {{ $pendaftar->jurusan->kode }}
                                @else
                                    -
                                @endif
                            </h3>
                            <p class="text-muted mb-0">Jurusan Pilihan</p>
                        </div>
                        <div class="stat-icon bg-warning-light">
                            <i class="fas fa-graduation-cap text-warning fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-{{ $pendaftar && $pendaftar->jurusan ? 'success' : 'secondary' }}">
                            @if($pendaftar && $pendaftar->jurusan)
                                {{ $pendaftar->jurusan->nama }}
                            @else
                                Belum Dipilih
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold">
                                @if($pendaftar && $pendaftar->no_pendaftaran)
                                    {{ substr($pendaftar->no_pendaftaran, -4) }}
                                @else
                                    -
                                @endif
                            </h3>
                            <p class="text-muted mb-0">No. Pendaftaran</p>
                        </div>
                        <div class="stat-icon bg-info-light">
                            <i class="fas fa-id-card text-info fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        @if($pendaftar && $pendaftar->no_pendaftaran)
                            <code class="badge bg-primary">{{ $pendaftar->no_pendaftaran }}</code>
                        @else
                            <span class="badge bg-secondary">Belum Ada</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8 mb-4">
            <div class="card system-status-card">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-list-check text-primary me-2"></i>
                            Langkah Pendaftaran
                        </h5>
                        @if(!($pendaftar && $pendaftar->dataSiswa && $pendaftar->dataOrtu && $pendaftar->asalSekolah))
                            <a href="/pendaftaran" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>Lanjutkan Pendaftaran
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @php
                        // Step 1: Data lengkap
                        $step1 = $pendaftar && $pendaftar->dataSiswa && $pendaftar->dataOrtu && $pendaftar->asalSekolah;
                        // Step 2: Upload berkas
                        $step2 = $pendaftar && $pendaftar->berkas && $pendaftar->berkas->count() > 0;
                        // Step 3: Submit
                        $step3 = $pendaftar && $pendaftar->status != 'DRAFT';
                        // Step 4: Verifikasi Admin
                        $step4 = $pendaftar && $pendaftar->status_berkas == 'VERIFIED' && $pendaftar->status_data == 'VERIFIED';
                        $step4_rejected = $pendaftar && ($pendaftar->status_berkas == 'REJECTED' || $pendaftar->status_data == 'REJECTED');
                        // Step 5: Pembayaran (hanya jika admin lulus)
                        $canPay = $step4;
                        $step5 = $pendaftar && $pendaftar->pembayaran && $pendaftar->pembayaran->bukti_pembayaran;
                        // Step 6: Verifikasi Keuangan
                        $step6 = $pendaftar && $pendaftar->pembayaran && $pendaftar->pembayaran->status_verifikasi == 'VERIFIED';
                        $step6_rejected = $pendaftar && $pendaftar->pembayaran && $pendaftar->pembayaran->status_verifikasi == 'REJECTED';
                        // Step 7: Pengumuman
                        $step7 = false; // Akan diatur nanti
                    @endphp
                    
                    <div class="list-group list-group-flush">
                        <!-- Step 1: Isi Data -->
                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $step1 ? 'list-group-item-success' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ $step1 ? 'bg-success' : 'bg-secondary' }} me-3">
                                    <i class="fas fa-{{ $step1 ? 'check' : 'user' }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">1. Isi Data Pendaftaran</h6>
                                    <small class="text-muted">Calon siswa mengisi seluruh formulir (data diri, orang tua, asal sekolah, pilihan jurusan)</small>
                                </div>
                            </div>
                            @if($step1)
                                <div class="d-flex gap-2">
                                    <span class="badge bg-success">Selesai</span>
                                    <a href="/pendaftaran" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                </div>
                            @else
                                <a href="/pendaftaran" class="btn btn-primary btn-sm">Isi Data</a>
                            @endif
                        </div>
                        
                        <!-- Step 2: Upload Berkas -->
                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $step2 ? 'list-group-item-success' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ $step2 ? 'bg-success' : 'bg-secondary' }} me-3">
                                    <i class="fas fa-{{ $step2 ? 'check' : 'file-upload' }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">2. Upload Berkas</h6>
                                    <small class="text-muted">Upload dokumen wajib: IJAZAH/RAPOR, KK, AKTA, KIP/KKS (opsional)</small>
                                </div>
                            </div>
                            @if($step2)
                                <div class="d-flex gap-2">
                                    <span class="badge bg-success">Selesai</span>
                                    <a href="/pendaftaran/berkas" class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                </div>
                            @elseif($step1)
                                <a href="/pendaftaran/berkas" class="btn btn-warning btn-sm">Upload</a>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </div>
                        
                        <!-- Step 3: Submit -->
                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $step3 ? 'list-group-item-success' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ $step3 ? 'bg-success' : 'bg-secondary' }} me-3">
                                    <i class="fas fa-{{ $step3 ? 'check' : 'paper-plane' }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">3. Submit Pendaftaran</h6>
                                    <small class="text-muted">Pendaftar menekan tombol submit → data terkunci</small>
                                </div>
                            </div>
                            @if($step3)
                                <span class="badge bg-success">Selesai</span>
                            @elseif($step1 && $step2)
                                <button class="btn btn-success btn-sm" onclick="submitPendaftaran()">Submit</button>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </div>
                        
                        <!-- Step 4: Verifikasi Admin -->
                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $step4 ? 'list-group-item-success' : ($step4_rejected ? 'list-group-item-danger' : '') }}">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ $step4 ? 'bg-success' : ($step4_rejected ? 'bg-danger' : 'bg-secondary') }} me-3">
                                    <i class="fas fa-{{ $step4 ? 'check' : ($step4_rejected ? 'times' : 'clipboard-check') }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">4. Verifikasi Administrasi</h6>
                                    <small class="text-muted">Verifikator mengecek data & berkas → Lulus / Perbaikan / Ditolak</small>
                                </div>
                            </div>
                            @if($step4)
                                <span class="badge bg-success">Selesai</span>
                            @elseif($step4_rejected)
                                <span class="badge bg-danger">Ditolak</span>
                            @elseif($step3)
                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </div>
                        
                        <!-- Step 5: Pembayaran -->
                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $step5 ? 'list-group-item-success' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ $step5 ? 'bg-success' : 'bg-secondary' }} me-3">
                                    <i class="fas fa-{{ $step5 ? 'check' : 'credit-card' }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">5. Pembayaran</h6>
                                    <small class="text-muted">Menampilkan nominal biaya & instruksi. Pendaftar upload bukti bayar</small>
                                </div>
                            </div>
                            @if($step5)
                                <span class="badge bg-success">Selesai</span>
                            @elseif($canPay)
                                <a href="/pendaftaran/pembayaran" class="btn btn-info btn-sm">Bayar</a>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </div>
                        
                        <!-- Step 6: Verifikasi Keuangan -->
                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $step6 ? 'list-group-item-success' : ($step6_rejected ? 'list-group-item-danger' : '') }}">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ $step6 ? 'bg-success' : ($step6_rejected ? 'bg-danger' : 'bg-secondary') }} me-3">
                                    <i class="fas fa-{{ $step6 ? 'check' : ($step6_rejected ? 'times' : 'money-check-alt') }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">6. Verifikasi Keuangan</h6>
                                    <small class="text-muted">Bagian keuangan memeriksa bukti pembayaran → valid / tidak</small>
                                </div>
                            </div>
                            @if($step6)
                                <span class="badge bg-success">Selesai</span>
                            @elseif($step6_rejected)
                                <span class="badge bg-danger">Ditolak</span>
                            @elseif($step5)
                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Info Card -->
            <div class="card system-status-card mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-info-circle text-warning me-2"></i>
                        Informasi Penting
                    </h5>
                </div>
                <div class="card-body">
                    @if($pendaftar && $pendaftar->hasil_keputusan)
                        <div class="alert alert-{{ $pendaftar->hasil_keputusan == 'LULUS' ? 'success' : ($pendaftar->hasil_keputusan == 'TIDAK_LULUS' ? 'danger' : 'info') }} text-center mb-3">
                            @if($pendaftar->hasil_keputusan == 'LULUS')
                                <i class="fas fa-trophy fa-2x mb-2"></i>
                                <h5 class="fw-bold">🎉 SELAMAT!</h5>
                                <p class="mb-0">Anda <strong>LULUS</strong> seleksi PPDB</p>
                            @elseif($pendaftar->hasil_keputusan == 'TIDAK_LULUS')
                                <i class="fas fa-times-circle fa-2x mb-2"></i>
                                <h5 class="fw-bold">Mohon Maaf</h5>
                                <p class="mb-0">Anda <strong>TIDAK LULUS</strong> seleksi PPDB</p>
                            @else
                                <i class="fas fa-hourglass-half fa-2x mb-2"></i>
                                <h5 class="fw-bold">Daftar Cadangan</h5>
                                <p class="mb-0">Anda masuk <strong>DAFTAR CADANGAN</strong></p>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info text-center mb-3">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <h6 class="fw-bold">Pengumuman Hasil Seleksi</h6>
                            <p class="mb-0 small">Pengumuman akan muncul setelah pendaftaran selesai dan proses seleksi berakhir</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card system-status-card">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    @if($pendaftar && $pendaftar->no_pendaftaran)
                        <div class="card bg-light mb-3">
                            <div class="card-body text-center py-3">
                                <h6 class="fw-bold mb-2">Kartu Peserta</h6>
                                <div class="mb-2">
                                    <small class="text-muted d-block">No. Pendaftaran</small>
                                    <code class="badge bg-primary fs-6">{{ $pendaftar->no_pendaftaran }}</code>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Nama Lengkap</small>
                                    <strong>{{ $pendaftar->dataSiswa->nama_lengkap ?? $pendaftar->dataSiswa->nama ?? $pendaftar->user->nama }}</strong>
                                </div>
                                <button class="btn btn-success w-100" onclick="cetakKartu()">
                                    <i class="fas fa-print me-2"></i>Cetak Kartu Peserta
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>Kartu peserta akan tersedia setelah pendaftaran selesai</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.step-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<script>
function submitPendaftaran() {
    if (confirm('Apakah Anda yakin ingin submit pendaftaran? Data akan terkunci dan tidak bisa diubah lagi.')) {
        // Submit logic here
        fetch('/pendaftaran/submit', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pendaftaran berhasil disubmit!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan saat submit pendaftaran.');
        });
    }
}

function cetakKartu() {
    window.open('/pendaftaran/cetak-kartu', '_blank');
}
</script>
@endsection