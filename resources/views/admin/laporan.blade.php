@extends('layouts.main')

@section('title', 'Laporan - PPDB Online')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                            <h3 class="fw-bold">{{ $statistics['total'] }}</h3>
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
                            <h3 class="fw-bold">{{ $statistics['verified'] }}</h3>
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
                            <h3 class="fw-bold">{{ $statistics['submitted'] }}</h3>
                            <p class="text-muted mb-0">Submitted</p>
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
                            <h3 class="fw-bold">{{ $statistics['paid'] }}</h3>
                            <p class="text-muted mb-0">Terbayar</p>
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
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-filter text-primary me-2"></i>
                    Filter & Export Data
                </h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-success" onclick="exportExcel()">
                        <i class="fas fa-file-excel me-2"></i>Export Excel
                    </button>
                    <button type="button" class="btn btn-danger" onclick="exportPDF()">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ url('/admin/laporan') }}" id="filterForm">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Jurusan</label>
                        <select class="form-select" name="jurusan" id="filterJurusan">
                            <option value="">Semua Jurusan</option>
                            @foreach($jurusan ?? [] as $j)
                                <option value="{{ $j->id }}" {{ request('jurusan') == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Gelombang</label>
                        <select class="form-select" name="gelombang" id="filterGelombang">
                            <option value="">Semua Gelombang</option>
                            @foreach($gelombang ?? [] as $g)
                                <option value="{{ $g->id }}" {{ request('gelombang') == $g->id ? 'selected' : '' }}>{{ $g->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="DRAFT" {{ request('status') == 'DRAFT' ? 'selected' : '' }}>Draft</option>
                            <option value="SUBMITTED" {{ request('status') == 'SUBMITTED' ? 'selected' : '' }}>Submitted</option>
                            <option value="VERIFIED_ADM" {{ request('status') == 'VERIFIED_ADM' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="REJECTED" {{ request('status') == 'REJECTED' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Periode</label>
                        <select class="form-select" name="periode" id="filterPeriode">
                            <option value="">Semua Periode</option>
                            <option value="today" {{ request('periode') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="week" {{ request('periode') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="month" {{ request('periode') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="custom" {{ request('periode') == 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3" id="customDateRange" style="{{ request('periode') == 'custom' ? '' : 'display:none' }}">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control mb-1" name="start_date" value="{{ request('start_date') }}" placeholder="Dari">
                        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}" placeholder="Sampai">
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary mt-4 w-100">
                            <i class="fas fa-search me-2"></i>Filter
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
                    <tbody>
                        @forelse($pendaftar as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->user->name ?? '-' }}</td>
                            <td>{{ $p->user->email ?? '-' }}</td>
                            <td>{{ $p->dataSiswa->nik ?? '-' }}</td>
                            <td>{{ $p->dataSiswa->nisn ?? '-' }}</td>
                            <td><span class="badge bg-primary">{{ $p->jurusan->nama ?? '-' }}</span></td>
                            <td><span class="badge bg-info">{{ $p->gelombang->nama ?? '-' }}</span></td>
                            <td><span class="badge bg-{{ $p->status == 'VERIFIED_ADM' ? 'success' : ($p->status == 'SUBMITTED' ? 'warning' : 'secondary') }}">{{ $p->status }}</span></td>
                            <td>{{ $p->created_at->format('d M Y') }}</td>
                            <td>{{ $p->pembayaran ? 'Rp ' . number_format($p->pembayaran->nominal, 0, ',', '.') : '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="fas fa-folder-open fa-2x mb-2"></i>
                                <p>Tidak ada data pendaftar</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Show/hide custom date range
document.getElementById('filterPeriode').addEventListener('change', function() {
    const customRange = document.getElementById('customDateRange');
    if (this.value === 'custom') {
        customRange.style.display = 'block';
    } else {
        customRange.style.display = 'none';
    }
});

// Export functions
function exportExcel() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    const params = new URLSearchParams(formData).toString();
    
    const url = '/admin/export/excel?' + params;
    window.open(url, '_blank');
}

function exportPDF() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    const params = new URLSearchParams(formData).toString();
    
    const url = '/admin/export/pdf?' + params;
    window.open(url, '_blank');
}

// Auto-submit form when filters change
document.querySelectorAll('#filterForm select').forEach(select => {
    select.addEventListener('change', function() {
        if (this.name !== 'periode' || this.value !== 'custom') {
            document.getElementById('filterForm').submit();
        }
    });
});
</script>
@endsection

