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
        $pendaftar = App\Models\Pendaftar::with(['dataSiswa', 'dataOrtu', 'asalSekolah', 'jurusan', 'berkas', 'gelombang'])->where('user_id', $user->id)->first();
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
        if (isset($pendaftar->pembayaran) && $pendaftar->pembayaran->bukti_pembayaran) $progress += 16.67;
        // Step 6: Verifikasi Keuangan (16.67%) - Final step = 100%
        if (isset($pendaftar->pembayaran) && $pendaftar->pembayaran->status_verifikasi == 'VERIFIED') $progress += 16.67;
    }
    $progress = round($progress);
@endphp

<div class="container mt-4">
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Validasi Error!</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    <!-- Welcome Header -->
    <div class="card system-status-card mb-4">
        <div class="card-body bg-gradient-primary text-white rounded">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
                    <p class="mb-0 opacity-75">Kelola pendaftaran PPDB Anda dengan mudah</p>
                    @php
                        $userGelombangInfo = null;
                        if ($user->gelombang_id) {
                            $userGelombangInfo = App\Models\Gelombang::find($user->gelombang_id);
                        }
                    @endphp
                    @if($userGelombangInfo)
                    <div class="mt-2">
                        <span class="badge bg-white text-primary"><i class="fas fa-calendar-check me-1"></i>Anda terdaftar di {{ $userGelombangInfo->nama }}</span>
                    </div>
                    @endif
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
                            @php
                                $userGelombang = null;
                                if ($pendaftar && $pendaftar->gelombang) {
                                    $userGelombang = $pendaftar->gelombang;
                                } elseif ($user->gelombang_id) {
                                    $userGelombang = App\Models\Gelombang::find($user->gelombang_id);
                                }
                            @endphp
                            <h3 class="fw-bold">
                                @if($userGelombang)
                                    {{ $userGelombang->nama }}
                                @else
                                    -
                                @endif
                            </h3>
                            <p class="text-muted mb-0">Gelombang Anda</p>
                        </div>
                        <div class="stat-icon bg-info-light">
                            <i class="fas fa-calendar-alt text-info fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        @if($userGelombang)
                            <div class="d-flex flex-column">
                                <span class="badge bg-info mb-1">{{ $userGelombang->nama }}</span>
                                <small class="text-muted">{{ date('d M Y', strtotime($userGelombang->tgl_mulai)) }} - {{ date('d M Y', strtotime($userGelombang->tgl_selesai)) }}</small>
                            </div>
                        @else
                            <span class="badge bg-secondary">Belum Terdaftar</span>
                        @endif
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
                        @php
                            $needRevision = $pendaftar && (
                                $pendaftar->status_berkas == 'REJECTED' || 
                                $pendaftar->status_data == 'REJECTED'
                            );
                        @endphp
                        @if($needRevision)
                            <form action="{{ url('/pendaftaran/berkas') }}" method="GET" style="display: inline;">
                                <button type="submit" class="btn btn-warning btn-sm">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Perbaiki Berkas
                                </button>
                            </form>
                        @elseif($pendaftar && $pendaftar->dataSiswa && $pendaftar->dataOrtu && $pendaftar->asalSekolah && $pendaftar->berkas && $pendaftar->berkas->count() > 0 && $pendaftar->status == 'DRAFT')
                            <a href="/pendaftaran" class="btn btn-success btn-sm">
                                <i class="fas fa-paper-plane me-1"></i>Lanjutkan Pendaftaran
                            </a>
                        @elseif($pendaftar && $pendaftar->dataSiswa && $pendaftar->dataOrtu && $pendaftar->asalSekolah)
                            <!-- Data sudah lengkap dan submitted -->
                        @else
                            <a href="/pendaftaran" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Mulai Pendaftaran
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
                        $step4 = $pendaftar && (($pendaftar->status_berkas == 'VERIFIED' && $pendaftar->status_data == 'VERIFIED') || $pendaftar->status == 'VERIFIED_ADM');
                        $step4_rejected = $pendaftar && (($pendaftar->status_berkas == 'REJECTED' || $pendaftar->status_data == 'REJECTED') || $pendaftar->status == 'REJECTED_ADM');
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
                        @php
                            $data_revision = $pendaftar && $pendaftar->status_data == 'REVISION';
                        @endphp
                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $step1 ? 'list-group-item-success' : ($data_revision ? 'list-group-item-warning' : '') }}">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ $step1 ? 'bg-success' : ($data_revision ? 'bg-warning' : 'bg-secondary') }} me-3">
                                    <i class="fas fa-{{ $step1 ? 'check' : ($data_revision ? 'exclamation-triangle' : 'user') }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">1. Isi Data Pendaftaran</h6>
                                    <small class="text-muted">Data diri, orang tua, asal sekolah, pilihan jurusan</small>
                                </div>
                            </div>
                            @if($step1)
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">Belum</span>
                            @endif
                        </div>
                        
                        <!-- Step 2: Upload Berkas -->
                        @php
                            $berkas_revision = $pendaftar && $pendaftar->status_berkas == 'REVISION';
                        @endphp
                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $step2 ? 'list-group-item-success' : ($berkas_revision ? 'list-group-item-warning' : '') }}">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ $step2 ? 'bg-success' : ($berkas_revision ? 'bg-warning' : 'bg-secondary') }} me-3">
                                    <i class="fas fa-{{ $step2 ? 'check' : ($berkas_revision ? 'exclamation-triangle' : 'file-upload') }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">2. Upload Berkas</h6>
                                    <small class="text-muted">IJAZAH/RAPOR, KK, AKTA, KIP/KKS (opsional)</small>
                                </div>
                            </div>
                            @if($step2)
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">Belum</span>
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
                                    <small class="text-muted">Kirim data untuk verifikasi</small>
                                </div>
                            </div>
                            @if($step3)
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">Belum</span>
                            @endif
                        </div>
                        
                        <!-- Step 4: Verifikasi Admin -->
                        @php
                            $step4_revision = $pendaftar && (($pendaftar->status_berkas == 'REVISION' || $pendaftar->status_data == 'REVISION'));
                        @endphp
                        <div class="list-group-item d-flex justify-content-between align-items-center {{ $step4 ? 'list-group-item-success' : ($step4_rejected ? 'list-group-item-danger' : ($step4_revision ? 'list-group-item-warning' : '')) }}">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ $step4 ? 'bg-success' : ($step4_rejected ? 'bg-danger' : ($step4_revision ? 'bg-warning' : 'bg-secondary')) }} me-3">
                                    <i class="fas fa-{{ $step4 ? 'check' : ($step4_rejected ? 'times' : ($step4_revision ? 'exclamation-triangle' : 'clipboard-check')) }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">4. Verifikasi Administrasi</h6>
                                    <small class="text-muted">Verifikator mengecek data & berkas</small>
                                </div>
                            </div>
                            @if($step4)
                                <span class="badge bg-success">Lulus</span>
                            @elseif($step4_rejected)
                                <span class="badge bg-danger">Ditolak</span>
                            @elseif($step4_revision)
                                <span class="badge bg-warning">Perlu Perbaikan</span>
                            @elseif($step3)
                                <span class="badge bg-info">Menunggu</span>
                            @else
                                <span class="badge bg-secondary">Belum</span>
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
                                    <small class="text-muted">Upload bukti pembayaran</small>
                                </div>
                            </div>
                            @if($step5)
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">Belum</span>
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
                                    <small class="text-muted">Verifikasi bukti pembayaran</small>
                                </div>
                            </div>
                            @if($step6)
                                <span class="badge bg-success">Selesai</span>
                            @elseif($step6_rejected)
                                <span class="badge bg-danger">Ditolak</span>
                            @elseif($step5)
                                <span class="badge bg-info">Menunggu</span>
                            @else
                                <span class="badge bg-secondary">Belum</span>
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
                                    <strong>{{ ($pendaftar->dataSiswa->nama_lengkap ?? $pendaftar->dataSiswa->nama) ?? ($pendaftar->user ? $pendaftar->user->name : 'N/A') }}</strong>
                                </div>
                                <button class="btn btn-success w-100 mb-2" onclick="cetakKartu()">
                                    <i class="fas fa-print me-2"></i>Cetak Kartu Peserta
                                </button>
                                @if($step3)
                                <button class="btn btn-info w-100" onclick="lihatFormulir()">
                                    <i class="fas fa-eye me-2"></i>Lihat Formulir
                                </button>
                                @endif
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

function lihatFormulir() {
    window.open('/pendaftaran/formulir', '_blank');
}
</script>
@endsection