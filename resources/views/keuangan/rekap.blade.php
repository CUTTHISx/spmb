@extends('layouts.main')

@section('title', 'Rekap Keuangan - PPDB Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/layouts/dashboard.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-success text-white border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-white bg-opacity-20 rounded-circle p-3">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">Rekap Keuangan</h2>
                            <p class="mb-0 opacity-90">Laporan pemasukan biaya pendaftaran per gelombang dan jurusan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Export Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form id="filterForm" method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="start_date" value="{{ request('start_date', date('Y-m-01')) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="end_date" value="{{ request('end_date', date('Y-m-d')) }}">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-1"></i>Filter
                                </button>
                                <a href="/keuangan/rekap" class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-refresh me-1"></i>Reset
                                </a>
                            </div>
                            <div class="col-md-3 text-end">
                                <button type="button" class="btn btn-success" onclick="exportExcel()">
                                    <i class="fas fa-file-excel me-1"></i>Export Excel
                                </button>
                                <button type="button" class="btn btn-danger ms-2" onclick="exportPDF()">
                                    <i class="fas fa-file-pdf me-1"></i>Export PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekap per Gelombang -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-wave-square text-primary me-2"></i>
                        Rekap per Gelombang
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-bold">Gelombang</th>
                                    <th class="border-0 fw-bold">Jumlah Pembayaran</th>
                                    <th class="border-0 fw-bold">Total Pemasukan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekapGelombang as $rekap)
                                <tr>
                                    <td class="py-3">
                                        <div class="fw-bold">{{ $rekap->nama_gelombang }}</div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-primary">{{ $rekap->jumlah_pembayaran }} pembayaran</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-success">Rp {{ number_format($rekap->total_pemasukan, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada data pembayaran</p>
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

    <!-- Rekap per Jurusan -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-graduation-cap text-info me-2"></i>
                        Rekap per Jurusan
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-bold">Jurusan</th>
                                    <th class="border-0 fw-bold">Jumlah Pembayaran</th>
                                    <th class="border-0 fw-bold">Total Pemasukan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekapJurusan as $rekap)
                                <tr>
                                    <td class="py-3">
                                        <div class="fw-bold">{{ $rekap->nama_jurusan }}</div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-info">{{ $rekap->jumlah_pembayaran }} pembayaran</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-success">Rp {{ number_format($rekap->total_pemasukan, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada data pembayaran</p>
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

@section('scripts')
<script>
function exportExcel() {
    const params = new URLSearchParams(window.location.search);
    window.location.href = '/keuangan/export/excel?' + params.toString();
}

function exportPDF() {
    const params = new URLSearchParams(window.location.search);
    window.location.href = '/keuangan/export/pdf?' + params.toString();
}
</script>
@endsection