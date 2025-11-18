@extends('layouts.main')

@section('title', 'Verifikasi Administrasi - PPDB Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/layouts/dashboard.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <!-- Header dengan Animasi -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-info text-white border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-white bg-opacity-20 rounded-circle p-3">
                                <i class="fas fa-clipboard-check fa-2x"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">Verifikasi Administrasi</h2>
                            <p class="mb-0 opacity-90">Cek data & berkas; tandai Lulus/Tolak/Perbaikan dengan catatan</p>
                        </div>
                        <div class="ms-auto">
                            <div class="text-end">
                                <small class="opacity-75">{{ count($pendaftar) }} Pendaftar</small>
                                <div class="fw-bold">{{ date('H:i') }} WIB</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-filter me-1"></i>Semua
                            </button>
                            <button class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-hourglass-half me-1"></i>Pending
                            </button>
                            <button class="btn btn-outline-success btn-sm">
                                <i class="fas fa-check me-1"></i>Verified
                            </button>
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-times me-1"></i>Rejected
                            </button>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-sync me-1"></i>Refresh
                            </button>
                            <a href="/dashboard/verifikator" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Verifikasi -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-list text-primary me-2"></i>
                        Daftar Pendaftar
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-bold">Pendaftar</th>
                                    <th class="border-0 fw-bold">Jurusan</th>
                                    <th class="border-0 fw-bold">Berkas</th>
                                    <th class="border-0 fw-bold">Status Berkas</th>
                                    <th class="border-0 fw-bold">Status Data</th>
                                    <th class="border-0 fw-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftar as $p)
                                <tr data-id="{{ $p->id }}">
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-{{ $p->status_berkas == 'VERIFIED' && $p->status_data == 'VERIFIED' ? 'success' : ($p->status_berkas == 'REJECTED' || $p->status_data == 'REJECTED' ? 'danger' : 'warning') }}-light rounded-circle p-2 me-3">
                                                <i class="fas fa-user text-{{ $p->status_berkas == 'VERIFIED' && $p->status_data == 'VERIFIED' ? 'success' : ($p->status_berkas == 'REJECTED' || $p->status_data == 'REJECTED' ? 'danger' : 'warning') }}"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $p->dataSiswa->nama ?? $p->user->name }}</div>
                                                <small class="text-muted">{{ $p->no_pendaftaran ?? 'PPDB'.date('Y').str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-info-light text-info">{{ $p->jurusan->nama ?? 'Belum Pilih' }}</span>
                                    </td>
                                    <td class="py-3">
                                        @php
                                            $berkasTypes = ['IJAZAH', 'KTP', 'KK', 'FOTO'];
                                            $uploadedBerkas = $p->berkas && $p->berkas->count() > 0 ? $p->berkas->pluck('jenis')->toArray() : [];
                                            $berkasCount = count($uploadedBerkas);
                                        @endphp
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 60px; height: 8px;">
                                                <div class="progress-bar bg-{{ $berkasCount == 4 ? 'success' : ($berkasCount >= 2 ? 'warning' : 'danger') }}" style="width: {{ ($berkasCount/4)*100 }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ $berkasCount }}/4</small>
                                        </div>
                                    </td>
                                    <td class="py-3 status-berkas-cell">
                                        @switch($p->status_berkas)
                                            @case('VERIFIED')
                                                <span class="badge bg-success">Terverifikasi</span>
                                                @break
                                            @case('REJECTED')
                                                <span class="badge bg-danger">Ditolak</span>
                                                @break
                                            @case('REVISION')
                                                <span class="badge bg-warning text-dark">Perbaikan</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Menunggu</span>
                                        @endswitch
                                    </td>
                                    <td class="py-3 status-data-cell">
                                        @switch($p->status_data)
                                            @case('VERIFIED')
                                                <span class="badge bg-success">Terverifikasi</span>
                                                @break
                                            @case('REJECTED')
                                                <span class="badge bg-danger">Ditolak</span>
                                                @break
                                            @case('REVISION')
                                                <span class="badge bg-warning text-dark">Perbaikan</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Menunggu</span>
                                        @endswitch
                                    </td>
                                    <td class="py-3 text-center action-cell">
                                        <a href="/verifikator/detail/{{ $p->id }}" class="badge bg-info-light text-info" style="cursor: pointer;" title="Detail">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada data pendaftar</p>
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

<!-- Verification Modal -->
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