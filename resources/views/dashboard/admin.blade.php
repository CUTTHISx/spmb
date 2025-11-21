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

    <!-- Ringkasan per Jurusan -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card system-status-card">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-graduation-cap text-primary me-2"></i>
                            Ringkasan per Jurusan
                        </h5>
                        <a href="/admin/master" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-cog me-1"></i>Kelola Jurusan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Jurusan</th>
                                    <th>Total Pendaftar</th>
                                    <th>Kuota</th>
                                    <th>Sisa Kuota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Jurusan::withCount('pendaftar')->get() as $jurusan)
                                <tr>
                                    <td><strong>{{ $jurusan->nama }}</strong><br><small class="text-muted">{{ $jurusan->kode }}</small></td>
                                    <td><span class="badge bg-primary">{{ $jurusan->pendaftar_count }}</span></td>
                                    <td><span class="badge bg-info">{{ $jurusan->kuota }}</span></td>
                                    <td>
                                        @php $sisa = max(0, $jurusan->kuota - $jurusan->pendaftar_count) @endphp
                                        <span class="badge {{ $sisa > 0 ? 'bg-success' : 'bg-danger' }}">{{ $sisa }}</span>
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        <i class="fas fa-info-circle me-2"></i>Belum ada data jurusan
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('dailyChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [@foreach($dailyStats as $stat)'{{ $stat->date }}',@endforeach],
                datasets: [{
                    label: 'Pendaftar Harian',
                    data: [@foreach($dailyStats as $stat){{ $stat->count }},@endforeach],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#007bff',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
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
    }
});
</script>
</script>
@endsection