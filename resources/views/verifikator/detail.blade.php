@extends('layouts.main')

@section('title', 'Detail Pendaftar - Verifikator')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/layouts/dashboard.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-info text-white border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                                    <i class="fas fa-user-check fa-2x"></i>
                                </div>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">{{ $pendaftar->dataSiswa->nama_lengkap ?? $pendaftar->dataSiswa->nama ?? $pendaftar->user->name }}</h2>
                                <p class="mb-0 opacity-90">{{ $pendaftar->no_pendaftaran ?? 'PPDB'.date('Y').str_pad($pendaftar->id, 4, '0', STR_PAD_LEFT) }} | {{ $pendaftar->jurusan->nama ?? 'Belum Memilih Jurusan' }}</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="d-flex gap-2 mb-2">
                                <span class="badge bg-{{ $pendaftar->status_berkas == 'VERIFIED' ? 'success' : ($pendaftar->status_berkas == 'REJECTED' ? 'danger' : 'warning') }}-light text-{{ $pendaftar->status_berkas == 'VERIFIED' ? 'success' : ($pendaftar->status_berkas == 'REJECTED' ? 'danger' : 'warning') }}">
                                    Berkas: {{ $pendaftar->status_berkas }}
                                </span>
                                <span class="badge bg-{{ $pendaftar->status_data == 'VERIFIED' ? 'success' : ($pendaftar->status_data == 'REJECTED' ? 'danger' : 'warning') }}-light text-{{ $pendaftar->status_data == 'VERIFIED' ? 'success' : ($pendaftar->status_data == 'REJECTED' ? 'danger' : 'warning') }}">
                                    Data: {{ $pendaftar->status_data }}
                                </span>
                            </div>
                            <a href="/verifikator/verifikasi" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Cards -->
    <div class="row g-4 mb-4">
        <!-- Data Pribadi -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="card-title mb-0 fw-bold text-primary">
                        <i class="fas fa-user me-2"></i>Data Pribadi
                    </h6>
                </div>
                <div class="card-body">
                    @if($pendaftar->dataSiswa)
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tr><td class="fw-bold text-muted" width="40%">Nama Lengkap</td><td>{{ $pendaftar->dataSiswa->nama ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">NIK</td><td>{{ $pendaftar->dataSiswa->nik ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">NISN</td><td>{{ $pendaftar->dataSiswa->nisn ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">Tempat Lahir</td><td>{{ $pendaftar->dataSiswa->tmp_lahir ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">Tanggal Lahir</td><td>{{ $pendaftar->dataSiswa->tgl_lahir ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">Jenis Kelamin</td><td>{{ $pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : ($pendaftar->dataSiswa->jk == 'P' ? 'Perempuan' : '-') }}</td></tr>
                            <tr><td class="fw-bold text-muted">Alamat</td><td>{{ $pendaftar->dataSiswa->alamat ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">Kecamatan</td><td>{{ $pendaftar->dataSiswa->kecamatan ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">Kelurahan</td><td>{{ $pendaftar->dataSiswa->kelurahan ?? '-' }}</td></tr>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                        <p class="text-danger mb-0">Data pribadi belum lengkap</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="card-title mb-0 fw-bold text-success">
                        <i class="fas fa-users me-2"></i>Data Orang Tua
                    </h6>
                </div>
                <div class="card-body">
                    @if($pendaftar->dataOrtu)
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tr><td class="fw-bold text-muted" width="40%">Nama Ayah</td><td>{{ $pendaftar->dataOrtu->nama_ayah ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">Pekerjaan Ayah</td><td>{{ $pendaftar->dataOrtu->pekerjaan_ayah ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">No. HP Ayah</td><td>{{ $pendaftar->dataOrtu->hp_ayah ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">Nama Ibu</td><td>{{ $pendaftar->dataOrtu->nama_ibu ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">Pekerjaan Ibu</td><td>{{ $pendaftar->dataOrtu->pekerjaan_ibu ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">No. HP Ibu</td><td>{{ $pendaftar->dataOrtu->hp_ibu ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">Nama Wali</td><td>{{ $pendaftar->dataOrtu->wali_nama ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">No. HP Wali</td><td>{{ $pendaftar->dataOrtu->wali_hp ?? '-' }}</td></tr>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                        <p class="text-danger mb-0">Data orang tua belum lengkap</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Asal Sekolah -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="card-title mb-0 fw-bold text-warning">
                        <i class="fas fa-school me-2"></i>Asal Sekolah
                    </h6>
                </div>
                <div class="card-body">
                    @if($pendaftar->asalSekolah)
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tr><td class="fw-bold text-muted" width="40%">Nama Sekolah</td><td>{{ $pendaftar->asalSekolah->nama_sekolah ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">NPSN</td><td>{{ $pendaftar->asalSekolah->npsn ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">Kabupaten</td><td>{{ $pendaftar->asalSekolah->kabupaten ?? '-' }}</td></tr>
                            <tr><td class="fw-bold text-muted">Nilai Rata-rata</td><td>{{ $pendaftar->asalSekolah->nilai_rata ?? '-' }}</td></tr>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                        <p class="text-danger mb-0">Data asal sekolah belum lengkap</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Berkas Upload -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="card-title mb-0 fw-bold text-info">
                        <i class="fas fa-file-alt me-2"></i>Berkas Upload
                    </h6>
                </div>
                <div class="card-body">
                    @if($pendaftar->berkas && $pendaftar->berkas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-bold">Jenis</th>
                                    <th class="border-0 fw-bold">Status</th>
                                    <th class="border-0 fw-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendaftar->berkas as $berkas)
                                <tr>
                                    <td class="py-2">
                                        <div>
                                            <div class="fw-bold">{{ ucfirst(strtolower($berkas->jenis)) }}</div>
                                            <small class="text-muted">{{ $berkas->ukuran_kb }} KB</small>
                                        </div>
                                    </td>
                                    <td class="py-2">
                                        <span class="badge bg-{{ $berkas->status_verifikasi == 'VERIFIED' ? 'success' : ($berkas->status_verifikasi == 'REJECTED' ? 'danger' : 'warning') }}-light text-{{ $berkas->status_verifikasi == 'VERIFIED' ? 'success' : ($berkas->status_verifikasi == 'REJECTED' ? 'danger' : 'warning') }}">
                                            {{ $berkas->status_verifikasi }}
                                        </span>
                                    </td>
                                    <td class="py-2 text-center">
                                        <a href="/{{ $berkas->url }}" target="_blank" class="badge bg-primary-light text-primary" style="cursor: pointer;" title="Lihat Berkas">
                                            <i class="fas fa-eye me-1"></i>Lihat
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>
                        <p class="text-danger mb-0">Belum ada berkas yang diupload</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Verifikasi Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="card-title mb-0 fw-bold">
                        <i class="fas fa-clipboard-check text-primary me-2"></i>Panel Verifikasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="fw-bold mb-3">Verifikasi Pendaftaran</h6>
                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            @if($pendaftar->status_berkas == 'PENDING' || $pendaftar->status_data == 'PENDING')
                            <span class="badge bg-success-light text-success" style="cursor: pointer;" onclick="showVerificationModal({{ $pendaftar->id }}, 'VERIFIED')" title="Lulus">
                                <i class="fas fa-check me-1"></i>Lulus
                            </span>
                            <span class="badge bg-warning-light text-warning" style="cursor: pointer;" onclick="showVerificationModal({{ $pendaftar->id }}, 'REVISION')" title="Perbaikan">
                                <i class="fas fa-edit me-1"></i>Perbaikan
                            </span>
                            <span class="badge bg-danger-light text-danger" style="cursor: pointer;" onclick="showVerificationModal({{ $pendaftar->id }}, 'REJECTED')" title="Tolak">
                                <i class="fas fa-times me-1"></i>Tolak
                            </span>
                            @else
                            <span class="badge bg-{{ $pendaftar->status_berkas == 'VERIFIED' ? 'success' : ($pendaftar->status_berkas == 'REJECTED' ? 'danger' : 'warning') }}">
                                <i class="fas fa-{{ $pendaftar->status_berkas == 'VERIFIED' ? 'check-circle' : ($pendaftar->status_berkas == 'REJECTED' ? 'times-circle' : 'edit') }} me-1"></i>{{ $pendaftar->status_berkas }}
                            </span>
                            @endif
                        </div>
                    </div>
                    @if($pendaftar->catatan_verifikasi)
                    <div class="mt-4 p-3 bg-light rounded border-start border-primary border-4">
                        <h6 class="fw-bold text-primary mb-2">
                            <i class="fas fa-sticky-note me-2"></i>Catatan Verifikasi
                        </h6>
                        <p class="mb-0">{{ $pendaftar->catatan_verifikasi }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Include the same verification modal from verifikasi.blade.php -->
<div class="modal fade" id="verificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="verificationForm">
                    <input type="hidden" id="pendaftarId">

                    <input type="hidden" id="verificationStatus">
                    
                    <div class="mb-3">
                        <label class="form-label">Status Verifikasi</label>
                        <div id="statusDisplay" class="form-control-plaintext"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="catatan" rows="3" placeholder="Berikan catatan verifikasi..." required></textarea>
                        <div class="form-text">Jelaskan alasan verifikasi atau perbaikan yang diperlukan</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitVerification()">Simpan Verifikasi</button>
            </div>
        </div>
    </div>
</div>

<script>
function showVerificationModal(id, status) {
    document.getElementById('pendaftarId').value = id;
    document.getElementById('verificationStatus').value = status;
    
    const statusText = status === 'VERIFIED' ? 'Lulus' : (status === 'REVISION' ? 'Perbaikan' : 'Tolak');
    const statusClass = status === 'VERIFIED' ? 'success' : (status === 'REVISION' ? 'warning' : 'danger');
    
    document.getElementById('statusDisplay').innerHTML = `<span class="badge bg-${statusClass}">${statusText}</span>`;
    document.getElementById('catatan').value = '';
    
    new bootstrap.Modal(document.getElementById('verificationModal')).show();
}

function submitVerification() {
    const id = document.getElementById('pendaftarId').value;
    const status = document.getElementById('verificationStatus').value;
    const catatan = document.getElementById('catatan').value;
    
    if (!catatan.trim() || catatan.trim().length < 5) {
        alert('Catatan harus diisi minimal 5 karakter!');
        return;
    }
    
    const submitBtn = document.querySelector('#verificationModal .btn-primary');
    
    // Disable button during request
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
    
    fetch(`/verifikator/verifikasi/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ 
            status: status, 
            catatan: catatan.trim() 
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.message || `HTTP ${response.status}: ${response.statusText}`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Verifikasi berhasil disimpan!');
            bootstrap.Modal.getInstance(document.getElementById('verificationModal')).hide();
            location.reload();
        } else {
            throw new Error(data.message || 'Terjadi kesalahan tidak diketahui');
        }
    })
    .catch(error => {
        console.error('Verification error:', error);
        alert('Error: ' + error.message);
    })
    .finally(() => {
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Simpan Verifikasi';
    });
}
</script>
@endsection