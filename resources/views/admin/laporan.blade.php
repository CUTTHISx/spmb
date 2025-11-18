@extends('layouts.main')

@section('title', 'Laporan - PPDB Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/layouts/dashboard.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <!-- Stats Overview -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold" id="totalPendaftar">0</h3>
                            <p class="text-muted mb-0">Total Pendaftar</p>
                        </div>
                        <div class="stat-icon bg-primary-light">
                            <i class="fas fa-users text-primary fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold" id="totalTerverifikasi">0</h3>
                            <p class="text-muted mb-0">Terverifikasi</p>
                        </div>
                        <div class="stat-icon bg-success-light">
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold" id="totalTerbayar">0</h3>
                            <p class="text-muted mb-0">Terbayar</p>
                        </div>
                        <div class="stat-icon bg-info-light">
                            <i class="fas fa-credit-card text-info fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold" id="totalPembayaran">Rp 0</h3>
                            <p class="text-muted mb-0">Total Pembayaran</p>
                        </div>
                        <div class="stat-icon bg-warning-light">
                            <i class="fas fa-money-bill text-warning fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Export -->
    <div class="card system-status-card mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-filter text-primary me-2"></i>
                Filter & Export Data
            </h5>
        </div>
        <div class="card-body">
            <form id="filterForm">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Jurusan</label>
                        <select class="form-select" id="filterJurusan" name="jurusan">
                            <option value="">Semua Jurusan</option>
                            @foreach($jurusan ?? [] as $j)
                                <option value="{{ $j->id }}">{{ $j->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Gelombang</label>
                        <select class="form-select" id="filterGelombang" name="gelombang">
                            <option value="">Semua Gelombang</option>
                            @foreach($gelombang ?? [] as $g)
                                <option value="{{ $g->id }}">{{ $g->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="filterStatus" name="status">
                            <option value="">Semua Status</option>
                            <option value="DRAFT">Draft</option>
                            <option value="SUBMITTED">Submitted</option>
                            <option value="VERIFIED_ADM">Terverifikasi</option>
                            <option value="REJECTED">Ditolak</option>
                            <option value="PAID">Terbayar</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Periode</label>
                        <select class="form-select" id="filterPeriode" name="periode">
                            <option value="">Semua Periode</option>
                            <option value="today">Hari Ini</option>
                            <option value="week">Minggu Ini</option>
                            <option value="month">Bulan Ini</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                </div>
                
                <div class="row" id="customDateRange" style="display: none;">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="startDate" name="start_date">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="endDate" name="end_date">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary me-2" onclick="loadData()">
                            <i class="fas fa-search me-2"></i>Filter Data
                        </button>
                        <button type="button" class="btn btn-success me-2" onclick="exportExcel()">
                            <i class="fas fa-file-excel me-2"></i>Export Excel
                        </button>
                        <button type="button" class="btn btn-danger" onclick="exportPDF()">
                            <i class="fas fa-file-pdf me-2"></i>Export PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card system-status-card">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-table text-primary me-2"></i>
                Data Pendaftar
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="laporanTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIK</th>
                            <th>NISN</th>
                            <th>Jurusan</th>
                            <th>Gelombang</th>
                            <th>Status</th>
                            <th>Tgl Daftar</th>
                            <th>Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody id="laporanTableBody">
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="fas fa-search fa-2x mb-2"></i>
                                <p>Klik "Filter Data" untuk menampilkan laporan</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentData = [];

// Show/hide custom date range
document.getElementById('filterPeriode').addEventListener('change', function() {
    const customRange = document.getElementById('customDateRange');
    if (this.value === 'custom') {
        customRange.style.display = 'block';
    } else {
        customRange.style.display = 'none';
    }
});

function loadData() {
    const formData = new FormData(document.getElementById('filterForm'));
    const params = new URLSearchParams(formData);
    
    fetch(`/admin/api/laporan-data?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            currentData = data.data || [];
            updateStatistics(data.statistics || {});
            updateTable();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat data laporan');
        });
}

function updateStatistics(stats) {
    document.getElementById('totalPendaftar').textContent = stats.total || 0;
    document.getElementById('totalTerverifikasi').textContent = stats.verified || 0;
    document.getElementById('totalTerbayar').textContent = stats.paid || 0;
    document.getElementById('totalPembayaran').textContent = 'Rp ' + (stats.total_payment || 0).toLocaleString('id-ID');
}

function updateTable() {
    const tbody = document.getElementById('laporanTableBody');
    
    if (currentData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="10" class="text-center text-muted py-4">
                    <i class="fas fa-folder-open fa-2x mb-2"></i>
                    <p>Tidak ada data sesuai filter</p>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = currentData.map((item, index) => `
        <tr>
            <td>${index + 1}</td>
            <td>${item.nama || '-'}</td>
            <td>${item.email || '-'}</td>
            <td>${item.nik || '-'}</td>
            <td>${item.nisn || '-'}</td>
            <td><span class="badge bg-primary">${item.jurusan || '-'}</span></td>
            <td><span class="badge bg-info">${item.gelombang || '-'}</span></td>
            <td><span class="badge bg-${getStatusColor(item.status)}">${getStatusText(item.status)}</span></td>
            <td>${item.tanggal_daftar || '-'}</td>
            <td>${item.pembayaran ? 'Rp ' + parseInt(item.pembayaran).toLocaleString('id-ID') : '-'}</td>
        </tr>
    `).join('');
}

function getStatusColor(status) {
    const colors = {
        'DRAFT': 'secondary',
        'SUBMITTED': 'warning',
        'VERIFIED_ADM': 'success',
        'REJECTED': 'danger',
        'PAID': 'info'
    };
    return colors[status] || 'secondary';
}

function getStatusText(status) {
    const texts = {
        'DRAFT': 'Draft',
        'SUBMITTED': 'Submitted',
        'VERIFIED_ADM': 'Terverifikasi',
        'REJECTED': 'Ditolak',
        'PAID': 'Terbayar'
    };
    return texts[status] || 'Unknown';
}

function exportExcel() {
    if (currentData.length === 0) {
        alert('Tidak ada data untuk diekspor. Silakan filter data terlebih dahulu.');
        return;
    }
    
    const formData = new FormData(document.getElementById('filterForm'));
    const params = new URLSearchParams(formData);
    
    window.open(`/admin/export/excel?${params.toString()}`, '_blank');
}

function exportPDF() {
    if (currentData.length === 0) {
        alert('Tidak ada data untuk diekspor. Silakan filter data terlebih dahulu.');
        return;
    }
    
    const formData = new FormData(document.getElementById('filterForm'));
    const params = new URLSearchParams(formData);
    
    window.open(`/admin/export/pdf?${params.toString()}`, '_blank');
}

// Load initial data
document.addEventListener('DOMContentLoaded', function() {
    loadData();
});
</script>
@endsection