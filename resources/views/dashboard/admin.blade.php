@extends('layouts.main')

@section('title', 'Dashboard Admin - PPDB Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/layouts/dashboard.css') }}">
@endsection

@section('content')
<div class="container mt-4">

    <!-- Stats Overview -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold">{{ $stats['total'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Total Pendaftar</p>
                        </div>
                        <div class="stat-icon bg-primary-light">
                            <i class="fas fa-users text-primary fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success">+12% dari bulan lalu</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold">{{ $stats['verified'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Terverifikasi</p>
                        </div>
                        <div class="stat-icon bg-success-light">
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-primary">{{ isset($stats['total']) && $stats['total'] > 0 ? round(($stats['verified']/$stats['total'])*100, 1) : 0 }}% dari total</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold">{{ $stats['submitted'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Menunggu Verifikasi</p>
                        </div>
                        <div class="stat-icon bg-warning-light">
                            <i class="fas fa-clock text-warning fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-warning">Perlu Tindakan</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold">{{ $stats['rejected'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Ditolak</p>
                        </div>
                        <div class="stat-icon bg-danger-light">
                            <i class="fas fa-times-circle text-danger fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-danger">{{ isset($stats['total']) && $stats['total'] > 0 ? round(($stats['rejected']/$stats['total'])*100, 1) : 0 }}% dari total</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Harian -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card system-status-card">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-calendar-day text-primary me-2"></i>
                        Ringkasan Harian - {{ date('d M Y') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Jurusan</th>
                                    <th>Total Pendaftar</th>
                                    <th>Terverifikasi</th>
                                    <th>Terbayar</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody id="jurusanTableBody">
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        Memuat data...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Pendaftaran -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card system-status-card">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Grafik Pendaftaran Harian
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="dailyChart" height="100"></canvas>
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
let dailyChart;

document.addEventListener('DOMContentLoaded', function() {
    loadDashboardData();
    
    // Auto refresh every 30 seconds
    setInterval(loadDashboardData, 30000);
});

function loadDashboardData() {
    // Load stats
    fetch('/admin/api/dashboard-stats')
        .then(response => response.json())
        .then(data => {
            document.querySelector('.stat-card:nth-child(1) h3').textContent = data.total;
            document.querySelector('.stat-card:nth-child(2) h3').textContent = data.verified;
            document.querySelector('.stat-card:nth-child(3) h3').textContent = data.submitted;
            document.querySelector('.stat-card:nth-child(4) h3').textContent = data.rejected;
            
            // Update percentages
            if (data.total > 0) {
                const verifiedPercent = Math.round((data.verified / data.total) * 100);
                const rejectedPercent = Math.round((data.rejected / data.total) * 100);
                document.querySelector('.stat-card:nth-child(2) .badge').textContent = verifiedPercent + '% dari total';
                document.querySelector('.stat-card:nth-child(4) .badge').textContent = rejectedPercent + '% dari total';
            }
        })
        .catch(error => console.error('Error loading stats:', error));
    
    // Load daily chart
    fetch('/admin/api/daily-chart')
        .then(response => response.json())
        .then(data => {
            if (dailyChart) {
                dailyChart.destroy();
            }
            
            const ctx = document.getElementById('dailyChart').getContext('2d');
            dailyChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Pendaftar Harian',
                        data: data.data,
                        borderColor: '#4361ee',
                        backgroundColor: 'rgba(67, 97, 238, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error loading chart:', error));
    
    // Load jurusan table data
    loadJurusanTable();
}

function loadJurusanTable() {
    fetch('/admin/api/jurusan-stats')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#jurusanTableBody');
            if (tbody) {
                tbody.innerHTML = '';
                
                data.labels.forEach((jurusan, index) => {
                    const count = data.data[index];
                    const progress = Math.min((count / 30) * 100, 100); // Assuming max 30 per jurusan
                    
                    const row = `
                        <tr>
                            <td><span class="fw-bold">${jurusan}</span></td>
                            <td><span class="badge bg-primary">${count}</span></td>
                            <td><span class="badge bg-success">${Math.floor(count * 0.8)}</span></td>
                            <td><span class="badge bg-info">${Math.floor(count * 0.6)}</span></td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: ${progress}%"></div>
                                </div>
                                <small class="text-muted">${Math.round(progress)}% dari target</small>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            }
        })
        .catch(error => console.error('Error loading jurusan data:', error));
}
</script>
@endsection