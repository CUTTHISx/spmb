@extends('layouts.main')

@section('title', 'Dashboard Verifikator - PPDB Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/layouts/dashboard.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <!-- Header dengan Animasi -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-info text-white border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-white bg-opacity-20 rounded-circle p-3">
                                <i class="fas fa-shield-alt fa-2x"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">Dashboard Verifikator</h2>
                            <p class="mb-0 opacity-90">Verifikasi kelengkapan data dan berkas administrasi pendaftar</p>
                        </div>
                        <div class="ms-auto">
                            <div class="text-end">
                                <small class="opacity-75">{{ date('d M Y') }}</small>
                                <div class="fw-bold">{{ date('H:i') }} WIB</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards dengan Progress -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold text-warning mb-1">{{ $pendingVerification }}</h3>
                            <p class="text-muted mb-0 small">Menunggu Verifikasi</p>
                        </div>
                        <div class="stat-icon bg-warning-light">
                            <i class="fas fa-hourglass-half text-warning fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-warning text-dark">Perlu Segera</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold text-success mb-1">{{ $verifiedAll }}</h3>
                            <p class="text-muted mb-0 small">Sudah Diverifikasi</p>
                        </div>
                        <div class="stat-icon bg-success-light">
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        @php
                            $percentage = $totalPendaftar > 0 ? round(($verifiedAll / $totalPendaftar) * 100) : 0;
                        @endphp
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-success" style="width: {{ $percentage }}%"></div>
                        </div>
                        <small class="text-success">{{ $percentage }}% dari total</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold text-danger mb-1">{{ $rejected }}</h3>
                            <p class="text-muted mb-0 small">Ditolak</p>
                        </div>
                        <div class="stat-icon bg-danger-light">
                            <i class="fas fa-times-circle text-danger fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-danger">Perlu Review</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold text-info mb-1">{{ $totalPendaftar }}</h3>
                            <p class="text-muted mb-0 small">Total Pendaftar</p>
                        </div>
                        <div class="stat-icon bg-info-light">
                            <i class="fas fa-bullseye text-info fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-info">Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <a href="/verifikator/verifikasi" class="text-decoration-none">
                <div class="card action-card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="me-4">
                                <div class="bg-gradient-primary rounded-3 p-3">
                                    <i class="fas fa-clipboard-check text-white fa-2x"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="fw-bold text-dark mb-2">Verifikasi Berkas & Data</h4>
                                <p class="text-muted mb-3">Periksa kelengkapan data pribadi, orang tua, dan berkas pendukung</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-primary-light text-primary">Validasi Data</span>
                                    <span class="badge bg-success-light text-success">Cek Berkas</span>
                                    <span class="badge bg-info-light text-info">Beri Catatan</span>
                                    <span class="badge bg-warning-light text-warning">Status</span>
                                </div>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-arrow-right text-muted fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="card-title mb-0 fw-bold">
                        <i class="fas fa-clock text-primary me-2"></i>
                        Aktivitas Hari Ini
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success-light rounded-circle p-2 me-3">
                            <i class="fas fa-check text-success"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">{{ $verifiedAll }} Berkas Diverifikasi</div>
                            <small class="text-muted">Total yang sudah selesai</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning-light rounded-circle p-2 me-3">
                            <i class="fas fa-exclamation text-warning"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">{{ $pendingVerification }} Berkas Menunggu</div>
                            <small class="text-muted">Perlu segera diproses</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-danger-light rounded-circle p-2 me-3">
                            <i class="fas fa-times text-danger"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">{{ $rejected }} Berkas Ditolak</div>
                            <small class="text-muted">Perlu perbaikan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Verifikasi Terbaru -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-list-check text-primary me-2"></i>
                            Antrian Verifikasi
                        </h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                            <button class="btn btn-outline-success btn-sm">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-bold">Pendaftar</th>
                                    <th class="border-0 fw-bold">Jurusan</th>
                                    <th class="border-0 fw-bold">Tanggal Daftar</th>
                                    <th class="border-0 fw-bold">Kelengkapan</th>

                                    <th class="border-0 fw-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $recentPendaftar = App\Models\Pendaftar::with(['user', 'jurusan', 'dataSiswa', 'dataOrtu', 'berkas'])
                                        ->whereIn('status', ['SUBMITTED', 'VERIFIED_ADM', 'REJECTED_ADM'])
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();
                                @endphp
                                @forelse($recentPendaftar as $p)
                                <tr>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning-light rounded-circle p-2 me-3">
                                                <i class="fas fa-user text-warning"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $p->user->name }}</div>
                                                <small class="text-muted">{{ $p->no_pendaftaran ?? 'Belum Ada' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-primary-light text-primary">{{ $p->jurusan->nama ?? 'Belum Pilih' }}</span>
                                    </td>
                                    <td class="py-3">
                                        <div>{{ $p->created_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $p->created_at->format('H:i') }} WIB</small>
                                    </td>
                                    <td class="py-3">
                                        @php
                                            $completeness = 0;
                                            if($p->dataSiswa) $completeness += 33;
                                            if($p->dataOrtu) $completeness += 33;
                                            if($p->berkas && $p->berkas->count() > 0) $completeness += 34;
                                        @endphp
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-{{ $completeness >= 80 ? 'success' : ($completeness >= 50 ? 'warning' : 'danger') }}" style="width: {{ $completeness }}%"></div>
                                        </div>
                                        <small class="text-{{ $completeness >= 80 ? 'success' : ($completeness >= 50 ? 'warning' : 'danger') }}">{{ $completeness }}% lengkap</small>
                                    </td>

                                    <td class="py-3 text-center">
                                        <a href="/verifikator/verifikasi" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i>Verifikasi
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <div>Tidak ada data yang perlu diverifikasi</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection