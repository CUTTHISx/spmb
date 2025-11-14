@extends('layouts.main')

@section('title', 'Detail Pendaftar - Verifikator')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-info text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-user-check me-2"></i>Detail Pendaftar</h5>
                <a href="/verifikator/verifikasi" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Header Info -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <h4>{{ $pendaftar->user->name }}</h4>
                    <p class="text-muted mb-1">{{ $pendaftar->no_pendaftaran ?? 'Belum Ada No. Pendaftaran' }}</p>
                    <p class="text-muted">{{ $pendaftar->jurusan->nama ?? 'Belum Memilih Jurusan' }}</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-{{ $pendaftar->status_berkas == 'VERIFIED' ? 'success' : ($pendaftar->status_berkas == 'REJECTED' ? 'danger' : 'warning') }} me-1">
                        Berkas: {{ $pendaftar->status_berkas }}
                    </span><br>
                    <span class="badge bg-{{ $pendaftar->status_data == 'VERIFIED' ? 'success' : ($pendaftar->status_data == 'REJECTED' ? 'danger' : 'warning') }}">
                        Data: {{ $pendaftar->status_data }}
                    </span>
                </div>
            </div>

            <div class="row">
                <!-- Data Pribadi -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-user me-2"></i>Data Pribadi</h6>
                        </div>
                        <div class="card-body">
                            @if($pendaftar->dataSiswa)
                            <table class="table table-sm">
                                <tr><td><strong>Nama Lengkap</strong></td><td>{{ $pendaftar->dataSiswa->nama ?? '-' }}</td></tr>
                                <tr><td><strong>NIK</strong></td><td>{{ $pendaftar->dataSiswa->nik ?? '-' }}</td></tr>
                                <tr><td><strong>NISN</strong></td><td>{{ $pendaftar->dataSiswa->nisn ?? '-' }}</td></tr>
                                <tr><td><strong>Tempat Lahir</strong></td><td>{{ $pendaftar->dataSiswa->tmp_lahir ?? '-' }}</td></tr>
                                <tr><td><strong>Tanggal Lahir</strong></td><td>{{ $pendaftar->dataSiswa->tgl_lahir ?? '-' }}</td></tr>
                                <tr><td><strong>Jenis Kelamin</strong></td><td>{{ $pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : ($pendaftar->dataSiswa->jk == 'P' ? 'Perempuan' : '-') }}</td></tr>
                                <tr><td><strong>Alamat</strong></td><td>{{ $pendaftar->dataSiswa->alamat ?? '-' }}</td></tr>
                                <tr><td><strong>Kecamatan</strong></td><td>{{ $pendaftar->dataSiswa->kecamatan ?? '-' }}</td></tr>
                                <tr><td><strong>Kelurahan</strong></td><td>{{ $pendaftar->dataSiswa->kelurahan ?? '-' }}</td></tr>
                            </table>
                            @else
                            <div class="text-danger">Data pribadi belum lengkap</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-users me-2"></i>Data Orang Tua</h6>
                        </div>
                        <div class="card-body">
                            @if($pendaftar->dataOrtu)
                            <table class="table table-sm">
                                <tr><td><strong>Nama Ayah</strong></td><td>{{ $pendaftar->dataOrtu->nama_ayah ?? '-' }}</td></tr>
                                <tr><td><strong>Pekerjaan Ayah</strong></td><td>{{ $pendaftar->dataOrtu->pekerjaan_ayah ?? '-' }}</td></tr>
                                <tr><td><strong>No. HP Ayah</strong></td><td>{{ $pendaftar->dataOrtu->hp_ayah ?? '-' }}</td></tr>
                                <tr><td><strong>Nama Ibu</strong></td><td>{{ $pendaftar->dataOrtu->nama_ibu ?? '-' }}</td></tr>
                                <tr><td><strong>Pekerjaan Ibu</strong></td><td>{{ $pendaftar->dataOrtu->pekerjaan_ibu ?? '-' }}</td></tr>
                                <tr><td><strong>No. HP Ibu</strong></td><td>{{ $pendaftar->dataOrtu->hp_ibu ?? '-' }}</td></tr>
                                <tr><td><strong>Nama Wali</strong></td><td>{{ $pendaftar->dataOrtu->wali_nama ?? '-' }}</td></tr>
                                <tr><td><strong>No. HP Wali</strong></td><td>{{ $pendaftar->dataOrtu->wali_hp ?? '-' }}</td></tr>
                            </table>
                            @else
                            <div class="text-danger">Data orang tua belum lengkap</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Asal Sekolah -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-warning text-white">
                            <h6 class="mb-0"><i class="fas fa-school me-2"></i>Asal Sekolah</h6>
                        </div>
                        <div class="card-body">
                            @if($pendaftar->asalSekolah)
                            <table class="table table-sm">
                                <tr><td><strong>Nama Sekolah</strong></td><td>{{ $pendaftar->asalSekolah->nama_sekolah ?? '-' }}</td></tr>
                                <tr><td><strong>NPSN</strong></td><td>{{ $pendaftar->asalSekolah->npsn ?? '-' }}</td></tr>
                                <tr><td><strong>Kabupaten</strong></td><td>{{ $pendaftar->asalSekolah->kabupaten ?? '-' }}</td></tr>
                                <tr><td><strong>Nilai Rata-rata</strong></td><td>{{ $pendaftar->asalSekolah->nilai_rata ?? '-' }}</td></tr>
                            </table>
                            @else
                            <div class="text-danger">Data asal sekolah belum lengkap</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Berkas Upload -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i>Berkas Upload</h6>
                        </div>
                        <div class="card-body">
                            @if($pendaftar->berkas && $pendaftar->berkas->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Jenis</th>
                                            <th>File</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendaftar->berkas as $berkas)
                                        <tr>
                                            <td>{{ ucfirst(strtolower($berkas->jenis)) }}</td>
                                            <td>
                                                <small>{{ $berkas->nama_file }}</small><br>
                                                <small class="text-muted">{{ $berkas->ukuran_kb }} KB</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $berkas->status_verifikasi == 'VERIFIED' ? 'success' : ($berkas->status_verifikasi == 'REJECTED' ? 'danger' : 'warning') }}">
                                                    {{ $berkas->status_verifikasi }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="/{{ $berkas->url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-danger">Belum ada berkas yang diupload</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Verifikasi Actions -->
            <div class="card mt-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Verifikasi</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Verifikasi Berkas</h6>
                            <div class="btn-group w-100" role="group">
                                <button class="btn btn-success btn-sm" onclick="showVerificationModal({{ $pendaftar->id }}, 'berkas', 'VERIFIED')" {{ $pendaftar->status_berkas != 'PENDING' ? 'disabled' : '' }}>
                                    <i class="fas fa-check"></i> Lulus
                                </button>
                                <button class="btn btn-warning btn-sm" onclick="showVerificationModal({{ $pendaftar->id }}, 'berkas', 'REVISION')" {{ $pendaftar->status_berkas != 'PENDING' ? 'disabled' : '' }}>
                                    <i class="fas fa-edit"></i> Perbaikan
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="showVerificationModal({{ $pendaftar->id }}, 'berkas', 'REJECTED')" {{ $pendaftar->status_berkas != 'PENDING' ? 'disabled' : '' }}>
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Verifikasi Data</h6>
                            <div class="btn-group w-100" role="group">
                                <button class="btn btn-success btn-sm" onclick="showVerificationModal({{ $pendaftar->id }}, 'data', 'VERIFIED')" {{ $pendaftar->status_data != 'PENDING' ? 'disabled' : '' }}>
                                    <i class="fas fa-check"></i> Lulus
                                </button>
                                <button class="btn btn-warning btn-sm" onclick="showVerificationModal({{ $pendaftar->id }}, 'data', 'REVISION')" {{ $pendaftar->status_data != 'PENDING' ? 'disabled' : '' }}>
                                    <i class="fas fa-edit"></i> Perbaikan
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="showVerificationModal({{ $pendaftar->id }}, 'data', 'REJECTED')" {{ $pendaftar->status_data != 'PENDING' ? 'disabled' : '' }}>
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </div>
                        </div>
                    </div>
                    @if($pendaftar->catatan_verifikasi)
                    <div class="mt-3 p-3 bg-light rounded">
                        <strong>Catatan Verifikasi:</strong><br>
                        {{ $pendaftar->catatan_verifikasi }}
                    </div>
                    @endif
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
                <h5 class="modal-title">Verifikasi <span id="modalType"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="verificationForm">
                    <input type="hidden" id="pendaftarId">
                    <input type="hidden" id="verificationType">
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
function showVerificationModal(id, type, status) {
    document.getElementById('pendaftarId').value = id;
    document.getElementById('verificationType').value = type;
    document.getElementById('verificationStatus').value = status;
    
    const typeText = type === 'berkas' ? 'Berkas' : 'Data';
    const statusText = status === 'VERIFIED' ? 'Lulus' : (status === 'REVISION' ? 'Perbaikan' : 'Tolak');
    const statusClass = status === 'VERIFIED' ? 'success' : (status === 'REVISION' ? 'warning' : 'danger');
    
    document.getElementById('modalType').textContent = typeText;
    document.getElementById('statusDisplay').innerHTML = `<span class="badge bg-${statusClass}">${statusText}</span>`;
    document.getElementById('catatan').value = '';
    
    new bootstrap.Modal(document.getElementById('verificationModal')).show();
}

function submitVerification() {
    const id = document.getElementById('pendaftarId').value;
    const type = document.getElementById('verificationType').value;
    const status = document.getElementById('verificationStatus').value;
    const catatan = document.getElementById('catatan').value;
    
    if (!catatan.trim()) {
        alert('Catatan harus diisi!');
        return;
    }
    
    const endpoint = type === 'berkas' ? `/verifikator/berkas/${id}` : `/verifikator/data/${id}`;
    
    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status: status, catatan: catatan })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('verificationModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}
</script>
@endsection