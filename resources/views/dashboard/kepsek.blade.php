@extends('layouts.main')

@section('title', 'Dashboard Eksekutif - PPDB Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/layouts/dashboard.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <!-- Executive Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-white bg-opacity-20 rounded-circle p-3">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">Dashboard Eksekutif</h2>
                            <p class="mb-0 opacity-90">Key Performance Indicators PPDB {{ date('Y') }}</p>
                        </div>
                        <div class="ms-auto text-end">
                            <div class="fw-bold h4">{{ date('d M Y') }}</div>
                            <small class="opacity-75">{{ date('H:i') }} WIB</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-primary-light mx-auto mb-3">
                        <i class="fas fa-users text-primary fa-2x"></i>
                    </div>
                    @php 
                        $totalKuota = \App\Models\Jurusan::sum('kuota') ?: 240;
                        $totalPendaftar = \App\Models\Pendaftar::count();
                        $persentase = $totalKuota > 0 ? round(($totalPendaftar / $totalKuota) * 100, 1) : 0;
                    @endphp
                    <h3 class="fw-bold text-primary">{{ $totalPendaftar }} / {{ $totalKuota }}</h3>
                    <p class="text-muted mb-2">Pendaftar vs Kuota</p>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: {{ min($persentase, 100) }}%"></div>
                    </div>
                    <small class="text-success">{{ $persentase }}% tercapai</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-success-light mx-auto mb-3">
                        <i class="fas fa-check-circle text-success fa-2x"></i>
                    </div>
                    @php 
                        $totalPendaftar = \App\Models\Pendaftar::count();
                        $terverifikasi = \App\Models\Pendaftar::where('status', 'VERIFIED_ADM')->count();
                        $rasioVerifikasi = $totalPendaftar > 0 ? round(($terverifikasi / $totalPendaftar) * 100, 1) : 0;
                    @endphp
                    <h3 class="fw-bold text-success">{{ $rasioVerifikasi }}%</h3>
                    <p class="text-muted mb-2">Rasio Terverifikasi</p>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ $rasioVerifikasi }}%"></div>
                    </div>
                    <small class="text-success">Target: 80%</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-warning-light mx-auto mb-3">
                        <i class="fas fa-money-bill-wave text-warning fa-2x"></i>
                    </div>
                    @php 
                        $biayaDaftar = \App\Models\Gelombang::where('is_active', true)->first()->biaya_daftar ?? 250000;
                        $pendaftarBayar = \App\Models\Pendaftar::whereHas('pembayaran', function($q) {
                            $q->where('status_verifikasi', 'VERIFIED');
                        })->count();
                        $totalPemasukan = $pendaftarBayar * $biayaDaftar;
                        $targetPemasukan = $totalKuota * $biayaDaftar;
                        $persentasePemasukan = $targetPemasukan > 0 ? round(($totalPemasukan / $targetPemasukan) * 100, 1) : 0;
                    @endphp
                    <h3 class="fw-bold text-warning">Rp {{ number_format($totalPemasukan/1000000, 1) }}M</h3>
                    <p class="text-muted mb-2">Total Pemasukan</p>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: {{ $persentasePemasukan }}%"></div>
                    </div>
                    <small class="text-warning">{{ $persentasePemasukan }}% dari target</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-info-light mx-auto mb-3">
                        <i class="fas fa-calendar-day text-info fa-2x"></i>
                    </div>
                    @php 
                        $pendaftarHariIni = \App\Models\Pendaftar::whereDate('created_at', now()->format('Y-m-d'))->count();
                        $pendaftarKemarin = \App\Models\Pendaftar::whereDate('created_at', now()->subDay()->format('Y-m-d'))->count();
                        $perubahanHarian = $pendaftarKemarin > 0 ? round((($pendaftarHariIni - $pendaftarKemarin) / $pendaftarKemarin) * 100) : ($pendaftarHariIni > 0 ? 100 : 0);
                    @endphp
                    <h3 class="fw-bold text-info">{{ $pendaftarHariIni }}</h3>
                    <p class="text-muted mb-2">Pendaftar Hari Ini</p>
                    <div class="d-flex justify-content-center">
                        <span class="badge {{ $perubahanHarian >= 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $perubahanHarian >= 0 ? '+' : '' }}{{ $perubahanHarian }}% dari kemarin
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Asal Sekolah Terbanyak -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-map-marker-alt text-info me-2"></i>
                        Asal Sekolah Terbanyak
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @php
                            $topSchools = \App\Models\PendaftarAsalSekolah::select('nama_sekolah', 'kabupaten')
                                ->selectRaw('COUNT(*) as jumlah')
                                ->groupBy('nama_sekolah', 'kabupaten')
                                ->orderBy('jumlah', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        @forelse($topSchools as $school)
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <div>
                                <div class="fw-bold">{{ $school->nama_sekolah ?: 'Tidak Diketahui' }}</div>
                                <small class="text-muted">{{ $school->kabupaten ?: '-' }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $school->jumlah }} siswa</span>
                        </div>
                        @empty
                        <div class="list-group-item border-0 px-0 text-center text-muted">
                            <i class="fas fa-info-circle me-2"></i>Belum ada data asal sekolah
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection