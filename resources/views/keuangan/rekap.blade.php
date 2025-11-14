@extends('layouts.main')

@section('title', 'Rekap Keuangan - PPDB Online')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Rekap Keuangan PPDB</h5>
                </div>
                <div class="card-body">
                    <!-- Filter & Export Controls -->
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <select class="form-select" id="filterGelombang">
                                <option value="">Semua Gelombang</option>
                                <option value="1">Gelombang 1</option>
                                <option value="2">Gelombang 2</option>
                                <option value="3">Gelombang 3</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="filterJurusan">
                                <option value="">Semua Jurusan</option>
                                <option value="PPLG">PPLG</option>
                                <option value="DKV">DKV</option>
                                <option value="AKUNTANSI">Akuntansi</option>
                                <option value="ANIMASI">Animasi</option>
                                <option value="BDP">BDP</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="endDate">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary me-2" onclick="filterData()">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                            <button class="btn btn-success me-2" onclick="exportExcel()">
                                <i class="fas fa-file-excel me-1"></i>Excel
                            </button>
                            <button class="btn btn-danger" onclick="exportPDF()">
                                <i class="fas fa-file-pdf me-1"></i>PDF
                            </button>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h4>Rp 15.750.000</h4>
                                    <small>Total Pemasukan</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h4>63</h4>
                                    <small>Pembayaran Lunas</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h4>12</h4>
                                    <small>Menunggu Bayar</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h4>Rp 250.000</h4>
                                    <small>Rata-rata per Siswa</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Section -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Tren Pemasukan Harian</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="revenueChart" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Pemasukan per Jurusan</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="jurusanChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Table -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Detail Pembayaran</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No Pendaftaran</th>
                                            <th>Nama Pendaftar</th>
                                            <th>Jurusan</th>
                                            <th>Gelombang</th>
                                            <th>Nominal</th>
                                            <th>Tanggal Bayar</th>
                                            <th>Metode</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>PPDB-2024-001</td>
                                            <td>Ahmad Rizki Pratama</td>
                                            <td><span class="badge bg-primary">PPLG</span></td>
                                            <td>Gelombang 1</td>
                                            <td class="fw-bold text-success">Rp 250.000</td>
                                            <td>12 Nov 2024</td>
                                            <td>Transfer Bank</td>
                                            <td><span class="badge bg-success">Lunas</span></td>
                                        </tr>
                                        <tr>
                                            <td>PPDB-2024-002</td>
                                            <td>Siti Nurhaliza</td>
                                            <td><span class="badge bg-info">DKV</span></td>
                                            <td>Gelombang 1</td>
                                            <td class="fw-bold text-success">Rp 250.000</td>
                                            <td>11 Nov 2024</td>
                                            <td>E-Wallet</td>
                                            <td><span class="badge bg-success">Lunas</span></td>
                                        </tr>
                                        <tr>
                                            <td>PPDB-2024-003</td>
                                            <td>Budi Santoso</td>
                                            <td><span class="badge bg-warning">Akuntansi</span></td>
                                            <td>Gelombang 1</td>
                                            <td class="fw-bold text-success">Rp 250.000</td>
                                            <td>10 Nov 2024</td>
                                            <td>Virtual Account</td>
                                            <td><span class="badge bg-success">Lunas</span></td>
                                        </tr>
                                        <tr>
                                            <td>PPDB-2024-004</td>
                                            <td>Dewi Sartika</td>
                                            <td><span class="badge bg-danger">Animasi</span></td>
                                            <td>Gelombang 2</td>
                                            <td class="fw-bold text-warning">Rp 250.000</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td><span class="badge bg-warning">Menunggu</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Trend Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['1 Nov', '2 Nov', '3 Nov', '4 Nov', '5 Nov', '6 Nov', '7 Nov'],
            datasets: [{
                label: 'Pemasukan Harian',
                data: [1250000, 2000000, 1750000, 2250000, 1500000, 2750000, 2250000],
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
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Jurusan Pie Chart
    const jurusanCtx = document.getElementById('jurusanChart').getContext('2d');
    new Chart(jurusanCtx, {
        type: 'doughnut',
        data: {
            labels: ['PPLG', 'DKV', 'Akuntansi', 'Animasi', 'BDP'],
            datasets: [{
                data: [5250000, 3750000, 3000000, 2250000, 1500000],
                backgroundColor: ['#007bff', '#17a2b8', '#ffc107', '#dc3545', '#6f42c1'],
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

function filterData() {
    console.log('Filtering data...');
}

function exportExcel() {
    alert('Export Excel functionality will be implemented');
}

function exportPDF() {
    alert('Export PDF functionality will be implemented');
}
</script>
@endsection