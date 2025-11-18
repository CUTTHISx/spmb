@extends('layouts.main')

@section('title', 'Pengumuman Hasil Seleksi - PPDB Online')

@section('content')
<div class="container mt-4">
    @if($pengumuman && $pengumuman->isActive())
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-{{ $hasilSeleksi == 'LULUS' ? 'success' : ($hasilSeleksi == 'TIDAK_LULUS' ? 'danger' : 'warning') }} text-white border-0 shadow-lg">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-{{ $hasilSeleksi == 'LULUS' ? 'trophy' : ($hasilSeleksi == 'TIDAK_LULUS' ? 'times-circle' : 'hourglass-half') }} fa-4x"></i>
                        </div>
                        <h1 class="fw-bold mb-2">
                            @if($hasilSeleksi == 'LULUS')
                                SELAMAT! ANDA DITERIMA
                            @elseif($hasilSeleksi == 'TIDAK_LULUS')
                                MOHON MAAF, ANDA BELUM BERHASIL
                            @else
                                HASIL MASIH DALAM PROSES
                            @endif
                        </h1>
                        <p class="mb-0 opacity-90">{{ $pendaftar->user->name }} - {{ $pendaftar->no_pendaftaran }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Hasil -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-clipboard-list text-primary me-2"></i>
                            Detail Hasil Seleksi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%" class="fw-bold text-muted">Nama Lengkap</td>
                                    <td>{{ $pendaftar->user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">No. Pendaftaran</td>
                                    <td>{{ $pendaftar->no_pendaftaran }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Jurusan Pilihan</td>
                                    <td>{{ $pendaftar->jurusan->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Status Berkas</td>
                                    <td>
                                        <span class="badge bg-{{ $pendaftar->status_berkas == 'VERIFIED' ? 'success' : ($pendaftar->status_berkas == 'REJECTED' ? 'danger' : 'warning') }}">
                                            {{ $pendaftar->status_berkas }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Status Data</td>
                                    <td>
                                        <span class="badge bg-{{ $pendaftar->status_data == 'VERIFIED' ? 'success' : ($pendaftar->status_data == 'REJECTED' ? 'danger' : 'warning') }}">
                                            {{ $pendaftar->status_data }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Status Pembayaran</td>
                                    <td>
                                        <span class="badge bg-{{ $pendaftar->status_pembayaran == 'LUNAS' ? 'success' : ($pendaftar->status_pembayaran == 'DITOLAK' ? 'danger' : 'warning') }}">
                                            {{ $pendaftar->status_pembayaran ?? 'PENDING' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Hasil Akhir</td>
                                    <td>
                                        <span class="badge bg-{{ $hasilSeleksi == 'LULUS' ? 'success' : ($hasilSeleksi == 'TIDAK_LULUS' ? 'danger' : 'warning') }} fs-6">
                                            {{ $hasilSeleksi == 'LULUS' ? 'DITERIMA' : ($hasilSeleksi == 'TIDAK_LULUS' ? 'TIDAK DITERIMA' : 'DALAM PROSES') }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        @if($pendaftar->catatan_keputusan)
                        <div class="mt-3 p-3 bg-light rounded border-start border-primary border-4">
                            <h6 class="fw-bold text-primary mb-2">
                                <i class="fas fa-sticky-note me-2"></i>Catatan Keputusan
                            </h6>
                            <p class="mb-0">{{ $pendaftar->catatan_keputusan }}</p>
                        </div>
                        @elseif($pendaftar->catatan_verifikasi)
                        <div class="mt-3 p-3 bg-light rounded border-start border-primary border-4">
                            <h6 class="fw-bold text-primary mb-2">
                                <i class="fas fa-sticky-note me-2"></i>Catatan Verifikasi
                            </h6>
                            <p class="mb-0">{{ $pendaftar->catatan_verifikasi }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                @if($hasilSeleksi == 'LULUS')
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success text-white py-3">
                        <h6 class="card-title mb-0 fw-bold">
                            <i class="fas fa-info-circle me-2"></i>
                            Langkah Selanjutnya
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Selamat!</strong> Anda diterima di {{ $pendaftar->jurusan->nama ?? 'jurusan pilihan' }}
                            </div>
                            <p class="text-muted small">
                                Silakan tunggu informasi lebih lanjut mengenai daftar ulang dan orientasi siswa baru.
                            </p>
                        </div>
                    </div>
                </div>
                @elseif($hasilSeleksi == 'TIDAK_LULUS')
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-danger text-white py-3">
                        <h6 class="card-title mb-0 fw-bold">
                            <i class="fas fa-info-circle me-2"></i>
                            Informasi
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle me-2"></i>
                            Mohon maaf, Anda belum berhasil dalam seleksi ini.
                        </div>
                        <p class="text-muted small">
                            Jangan berkecil hati. Anda dapat mencoba lagi pada gelombang berikutnya atau mencari alternatif sekolah lain.
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    @else
        <!-- Pengumuman Belum Aktif -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-clock fa-4x text-muted mb-3"></i>
                        <h3 class="fw-bold text-muted">Pengumuman Belum Tersedia</h3>
                        <p class="text-muted">
                            @if($pengumuman)
                                Pengumuman akan diumumkan pada: 
                                <strong>{{ $pengumuman->tanggal_pengumuman->format('d F Y') }} pukul {{ $pengumuman->jam_pengumuman }} WIB</strong>
                            @else
                                Pengumuman belum dijadwalkan. Silakan hubungi admin untuk informasi lebih lanjut.
                            @endif
                        </p>
                        <a href="/dashboard/pendaftar" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection