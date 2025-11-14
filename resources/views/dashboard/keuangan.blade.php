@extends('layouts.main')

@section('title', 'Dashboard Keuangan - PPDB Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/layouts/dashboard.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <!-- Header dengan Animasi -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-success text-white border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-white bg-opacity-20 rounded-circle p-3">
                                <i class="fas fa-coins fa-2x"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">Dashboard Keuangan</h2>
                            <p class="mb-0 opacity-90">Kelola verifikasi pembayaran dan laporan keuangan PPDB</p>
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

    <!-- Stats Cards dengan Animasi Hover -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold text-success mb-1">Rp 12.5M</h3>
                            <p class="text-muted mb-0 small">Total Pemasukan</p>
                        </div>
                        <div class="stat-icon bg-success-light">
                            <i class="fas fa-money-bill-wave text-success fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-success" style="width: 85%"></div>
                        </div>
                        <small class="text-success">85% dari target</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold text-warning mb-1">8</h3>
                            <p class="text-muted mb-0 small">Menunggu Verifikasi</p>
                        </div>
                        <div class="stat-icon bg-warning-light">
                            <i class="fas fa-hourglass-half text-warning fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-warning text-dark">Perlu Tindakan</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold text-success mb-1">50</h3>
                            <p class="text-muted mb-0 small">Terverifikasi</p>
                        </div>
                        <div class="stat-icon bg-success-light">
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success">86% dari total</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold text-danger mb-1">2</h3>
                            <p class="text-muted mb-0 small">Ditolak</p>
                        </div>
                        <div class="stat-icon bg-danger-light">
                            <i class="fas fa-times-circle text-danger fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-danger">3% dari total</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions dengan Animasi -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <a href="/keuangan/verifikasi" class="text-decoration-none">
                <div class="card action-card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="me-4">
                                <div class="bg-gradient-primary rounded-3 p-3">
                                    <i class="fas fa-receipt text-white fa-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold text-dark mb-2">Verifikasi Pembayaran</h5>
                                <p class="text-muted mb-3 small">Periksa dan konfirmasi bukti pembayaran pendaftar</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-primary-light text-primary">Cek Bukti</span>
                                    <span class="badge bg-success-light text-success">Konfirmasi</span>
                                    <span class="badge bg-info-light text-info">Notifikasi</span>
                                </div>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-arrow-right text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-6">
            <a href="/keuangan/rekap" class="text-decoration-none">
                <div class="card action-card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="me-4">
                                <div class="bg-gradient-success rounded-3 p-3">
                                    <i class="fas fa-chart-line text-white fa-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold text-dark mb-2">Laporan Keuangan</h5>
                                <p class="text-muted mb-3 small">Rekap pemasukan dan analisis keuangan PPDB</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-success-light text-success">Export Excel</span>
                                    <span class="badge bg-danger-light text-danger">Export PDF</span>
                                    <span class="badge bg-warning-light text-warning">Grafik</span>
                                </div>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-arrow-right text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Grafik Keuangan -->
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-area text-success me-2"></i>
                        Tren Pembayaran Mingguan
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="paymentChart" height="100"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-pie-chart text-info me-2"></i>
                        Status Pembayaran
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pembayaran Terbaru dengan Fitur Advanced -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-history text-primary me-2"></i>
                            Pembayaran Terbaru
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
                                    <th class="border-0 fw-bold">Nominal</th>
                                    <th class="border-0 fw-bold">Tanggal</th>
                                    <th class="border-0 fw-bold">Metode</th>
                                    <th class="border-0 fw-bold">Status</th>
                                    <th class="border-0 fw-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary-light rounded-circle p-2 me-3">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">Ahmad Siswa</div>
                                                <small class="text-muted">PPDB-2024-00001</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-success">Rp 250.000</span>
                                    </td>
                                    <td class="py-3">
                                        <div>12 Nov 2024</div>
                                        <small class="text-muted">14:30 WIB</small>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-info-light text-info">Transfer Bank</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary" title="Verifikasi">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-info" title="Lihat Bukti">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success-light rounded-circle p-2 me-3">
                                                <i class="fas fa-user text-success"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">Siti Nurhaliza</div>
                                                <small class="text-muted">PPDB-2024-00002</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-success">Rp 250.000</span>
                                    </td>
                                    <td class="py-3">
                                        <div>11 Nov 2024</div>
                                        <small class="text-muted">10:15 WIB</small>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-success-light text-success">E-Wallet</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-success">Terverifikasi</span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <button class="btn btn-sm btn-outline-secondary" disabled>
                                            <i class="fas fa-check-circle"></i> Selesai
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning-light rounded-circle p-2 me-3">
                                                <i class="fas fa-user text-warning"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">Budi Santoso</div>
                                                <small class="text-muted">PPDB-2024-00003</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-success">Rp 250.000</span>
                                    </td>
                                    <td class="py-3">
                                        <div>10 Nov 2024</div>
                                        <small class="text-muted">16:45 WIB</small>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-primary-light text-primary">Virtual Account</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary" title="Verifikasi">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-info" title="Lihat Bukti">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
    // Payment Trend Chart
    const paymentCtx = document.getElementById('paymentChart').getContext('2d');
    new Chart(paymentCtx, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Pembayaran Masuk',
                data: [12, 19, 15, 25, 22, 18, 8],
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
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
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Status Pie Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Terverifikasi', 'Menunggu', 'Ditolak'],
            datasets: [{
                data: [50, 8, 2],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
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
});
</script>
@endsection
