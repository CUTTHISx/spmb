@extends('layouts.main')

@section('title', 'Status Pendaftaran - PPDB Online')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-clipboard-check me-2"></i>
                Status Pendaftaran
            </h4>
        </div>
        <div class="card-body">
            @if($pendaftar)
                <div class="alert alert-info mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-3"></i>
                        <div>
                            <h5 class="mb-1">No. Pendaftaran: {{ $pendaftar->no_pendaftaran }}</h5>
                            <p class="mb-0">Status: <strong>{{ $pendaftar->status }}</strong></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6>Data Siswa</h6>
                        @if($pendaftar->dataSiswa)
                            <p><strong>Nama:</strong> {{ $pendaftar->dataSiswa->nama }}</p>
                            <p><strong>NIK:</strong> {{ $pendaftar->dataSiswa->nik }}</p>
                            <p><strong>NISN:</strong> {{ $pendaftar->dataSiswa->nisn }}</p>
                        @else
                            <p class="text-muted">Data belum lengkap</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>Jurusan</h6>
                        @if($pendaftar->jurusan)
                            <p><strong>{{ $pendaftar->jurusan->nama }}</strong></p>
                        @else
                            <p class="text-muted">Belum dipilih</p>
                        @endif
                    </div>
                </div>

                <hr>

                <h6>Progress Pendaftaran</h6>
                <div class="list-group">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Data Pendaftaran</span>
                        @if($pendaftar->dataSiswa)
                            <span class="badge bg-success">Selesai</span>
                        @else
                            <span class="badge bg-secondary">Belum</span>
                        @endif
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Upload Berkas</span>
                        @if($pendaftar->berkas && $pendaftar->berkas->count() > 0)
                            <span class="badge bg-success">Selesai</span>
                        @else
                            <span class="badge bg-secondary">Belum</span>
                        @endif
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Verifikasi Data</span>
                        <span class="badge bg-{{ $pendaftar->status_data == 'VERIFIED' ? 'success' : ($pendaftar->status_data == 'REJECTED' ? 'danger' : 'warning') }}">
                            {{ $pendaftar->status_data ?? 'Pending' }}
                        </span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Verifikasi Berkas</span>
                        <span class="badge bg-{{ $pendaftar->status_berkas == 'VERIFIED' ? 'success' : ($pendaftar->status_berkas == 'REJECTED' ? 'danger' : 'warning') }}">
                            {{ $pendaftar->status_berkas ?? 'Pending' }}
                        </span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Verifikasi Pembayaran</span>
                        <span class="badge bg-{{ $pendaftar->status_payment == 'VERIFIED' ? 'success' : ($pendaftar->status_payment == 'REJECTED' ? 'danger' : 'warning') }}">
                            {{ $pendaftar->status_payment ?? 'Pending' }}
                        </span>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Anda belum memiliki data pendaftaran.
                </div>
            @endif

            <div class="mt-4">
                <a href="/dashboard/pendaftar" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection