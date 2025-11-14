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
                    <h3 class="fw-bold text-primary">75 / 120</h3>
                    <p class="text-muted mb-2">Pendaftar vs Kuota</p>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: 62.5%"></div>
                    </div>
                    <small class="text-success">62.5% tercapai</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-success-light mx-auto mb-3">
                        <i class="fas fa-check-circle text-success fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-success">85%</h3>
                    <p class="text-muted mb-2">Rasio Terverifikasi</p>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 85%"></div>
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
                    <h3 class="fw-bold text-warning">Rp 18.75M</h3>
                    <p class="text-muted mb-2">Total Pemasukan</p>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: 78%"></div>
                    </div>
                    <small class="text-warning">78% dari target</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-info-light mx-auto mb-3">
                        <i class="fas fa-calendar-day text-info fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-info">12</h3>
                    <p class="text-muted mb-2">Pendaftar Hari Ini</p>
                    <div class="d-flex justify-content-center">
                        <span class="badge bg-success">+15% dari kemarin</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-area text-primary me-2"></i>
                        Tren Pendaftaran 30 Hari Terakhir
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="trendChart" height="100"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-graduation-cap text-success me-2"></i>
                        Komposisi Jurusan
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="jurusanChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Regional Analysis -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-map-marker-alt text-info me-2"></i>
                        Asal Sekolah Terbanyak
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <div>
                                <div class="fw-bold">SMPN 1 Cileunyi</div>
                                <small class="text-muted">Cileunyi, Bandung</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">15 siswa</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <div>
                                <div class="fw-bold">SMPN 2 Bandung</div>
                                <small class="text-muted">Bandung Kota</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">12 siswa</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <div>
                                <div class="fw-bold">SMP Al-Azhar</div>
                                <small class="text-muted">Bandung Kota</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">10 siswa</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <div>
                                <div class="fw-bold">SMPN 5 Cimahi</div>
                                <small class="text-muted">Cimahi</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">8 siswa</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-globe text-warning me-2"></i>
                        Sebaran Wilayah
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="wilayahChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-bolt text-primary me-2"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="/admin/laporan" class="quick-action-btn text-decoration-none">
                                <i class="fas fa-file-alt text-primary fa-2x mb-2"></i>
                                <div class="fw-bold">Laporan Lengkap</div>
                                <small class="text-muted">Export data pendaftar</small>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="/admin/peta" class="quick-action-btn text-decoration-none">
                                <i class="fas fa-map text-success fa-2x mb-2"></i>
                                <div class="fw-bold">Peta Sebaran</div>
                                <small class="text-muted">Visualisasi geografis</small>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="/keuangan/rekap" class="quick-action-btn text-decoration-none">
                                <i class="fas fa-chart-pie text-warning fa-2x mb-2"></i>
                                <div class="fw-bold">Analisis Keuangan</div>
                                <small class="text-muted">Rekap pemasukan</small>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="/admin/monitoring" class="quick-action-btn text-decoration-none">
                                <i class="fas fa-eye text-info fa-2x mb-2"></i>
                                <div class="fw-bold">Monitoring Real-time</div>
                                <small class="text-muted">Status terkini</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/layouts/dashboard.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Trend Chart
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: Array.from({length: 30}, (_, i) => `${i+1} Nov`),
            datasets: [{
                label: 'Pendaftar Harian',
                data: [2, 5, 3, 8, 6, 12, 9, 15, 11, 18, 14, 22, 19, 25, 21, 28, 24, 32, 29, 35, 31, 38, 34, 42, 39, 45, 41, 48, 44, 52],
                borderColor: '#4361ee',
                backgroundColor: 'rgba(67, 97, 238, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Jurusan Chart
    const jurusanCtx = document.getElementById('jurusanChart').getContext('2d');
    new Chart(jurusanCtx, {
        type: 'doughnut',
        data: {
            labels: ['PPLG', 'DKV', 'Akuntansi', 'Animasi', 'BDP'],
            datasets: [{
                data: [25, 18, 15, 12, 5],
                backgroundColor: ['#4361ee', '#4cc9f0', '#f72585', '#4895ef', '#3f37c9'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Wilayah Chart
    const wilayahCtx = document.getElementById('wilayahChart').getContext('2d');
    new Chart(wilayahCtx, {
        type: 'bar',
        data: {
            labels: ['Bandung', 'Cileunyi', 'Cimahi', 'Sumedang', 'Lainnya'],
            datasets: [{
                data: [35, 20, 12, 5, 3],
                backgroundColor: ['#4361ee', '#4cc9f0', '#f72585', '#4895ef', '#3f37c9'],
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endsection