@extends('layouts.main')

@section('title', 'Keputusan PPDB - Admin')

@section('content')
<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">Keputusan PPDB</h3>
                    <p class="text-muted mb-0">Tentukan hasil akhir pendaftaran siswa</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" onclick="exportKeputusan()">
                        <i class="fas fa-download me-2"></i>Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="fas fa-hourglass-half text-warning fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-0 fw-bold">{{ $stats['siap_keputusan'] }}</h4>
                            <p class="text-muted mb-0 small">Siap Keputusan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="fas fa-check-circle text-success fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-0 fw-bold">{{ $stats['lulus'] }}</h4>
                            <p class="text-muted mb-0 small">Lulus</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger bg-opacity-10 p-3 rounded-3">
                                <i class="fas fa-times-circle text-danger fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-0 fw-bold">{{ $stats['tidak_lulus'] }}</h4>
                            <p class="text-muted mb-0 small">Tidak Lulus</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                <i class="fas fa-list text-info fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-0 fw-bold">{{ $stats['cadangan'] }}</h4>
                            <p class="text-muted mb-0 small">Cadangan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0 fw-semibold">Data Pendaftar</h5>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <select class="form-select form-select-sm" style="width: auto;" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="siap">Siap Keputusan</option>
                            <option value="lulus">Lulus</option>
                            <option value="tidak_lulus">Tidak Lulus</option>
                            <option value="cadangan">Cadangan</option>
                        </select>
                        <input type="text" class="form-control form-control-sm" placeholder="Cari nama/no daftar..." style="width: 200px;" id="searchInput">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="keputusanTable">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 fw-semibold">No. Daftar</th>
                            <th class="border-0 fw-semibold">Nama Lengkap</th>
                            <th class="border-0 fw-semibold">Jurusan</th>
                            <th class="border-0 fw-semibold">Verifikasi</th>
                            <th class="border-0 fw-semibold">Pembayaran</th>
                            <th class="border-0 fw-semibold">Keputusan</th>
                            <th class="border-0 fw-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftar as $item)
                        <tr>
                            <td class="align-middle">
                                <span class="badge bg-primary fs-6">{{ $item->no_pendaftaran }}</span>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $item->dataSiswa->nama_lengkap ?? $item->dataSiswa->nama ?? $item->user->nama }}</div>
                                        <small class="text-muted">{{ $item->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <span class="badge bg-light text-dark">{{ $item->jurusan->nama ?? '-' }}</span>
                            </td>
                            <td class="align-middle">
                                @if($item->status_berkas == 'VERIFIED' && $item->status_data == 'VERIFIED')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Terverifikasi</span>
                                @elseif($item->status_berkas == 'REJECTED' || $item->status_data == 'REJECTED')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Ditolak</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Menunggu</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($item->pembayaran && $item->pembayaran->status_verifikasi == 'VERIFIED')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Terbayar</span>
                                @elseif($item->pembayaran && $item->pembayaran->status_verifikasi == 'REJECTED')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Ditolak</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Menunggu</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($item->hasil_keputusan)
                                    @if($item->hasil_keputusan == 'LULUS')
                                        <span class="badge bg-success fs-6">Lulus</span>
                                    @elseif($item->hasil_keputusan == 'TIDAK_LULUS')
                                        <span class="badge bg-danger fs-6">Tidak Lulus</span>
                                    @else
                                        <span class="badge bg-info fs-6">Cadangan</span>
                                    @endif
                                    <div class="small text-muted mt-1">
                                        {{ $item->tgl_keputusan ? \Carbon\Carbon::parse($item->tgl_keputusan)->format('d/m/Y H:i') : '' }}
                                    </div>
                                @else
                                    <span class="badge bg-secondary fs-6">Belum Diputuskan</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                @if(!$item->hasil_keputusan && $item->status_berkas == 'VERIFIED' && $item->status_data == 'VERIFIED' && $item->pembayaran && $item->pembayaran->status_verifikasi == 'VERIFIED')
                                    <button class="btn btn-primary btn-sm" onclick="buatKeputusan({{ $item->id }}, '{{ addslashes($item->dataSiswa->nama_lengkap ?? $item->dataSiswa->nama ?? $item->user->nama) }}')">
                                        <i class="fas fa-gavel me-1"></i>Putuskan
                                    </button>
                                @else
                                    <button class="btn btn-outline-secondary btn-sm" onclick="lihatDetail({{ $item->id }})">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada data pendaftar</h5>
                                    <p class="text-muted mb-0">Data pendaftar yang siap untuk diputuskan akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Keputusan -->
<div class="modal fade" id="keputusanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-semibold">
                    <i class="fas fa-gavel me-2"></i>Buat Keputusan PPDB
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="keputusanForm">
                <div class="modal-body p-4">
                    <input type="hidden" id="pendaftar_id" name="pendaftar_id">
                    
                    <!-- Pendaftar Info -->
                    <div class="alert alert-light border mb-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar-lg bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fas fa-user text-primary fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-semibold">Nama Pendaftar</h6>
                                <p id="nama_pendaftar" class="mb-0 text-muted"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Keputusan Form -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Hasil Keputusan <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg" name="hasil_keputusan" required>
                                    <option value="">Pilih Keputusan</option>
                                    <option value="LULUS" data-icon="fas fa-check-circle text-success">✅ Lulus</option>
                                    <option value="TIDAK_LULUS" data-icon="fas fa-times-circle text-danger">❌ Tidak Lulus</option>
                                    <option value="CADANGAN" data-icon="fas fa-list text-info">📋 Cadangan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal Keputusan</label>
                                <input type="text" class="form-control" value="{{ date('d/m/Y H:i') }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan Keputusan</label>
                        <textarea class="form-control" name="catatan_keputusan" rows="4" placeholder="Berikan catatan atau alasan keputusan (opsional)..."></textarea>
                        <div class="form-text">Catatan ini akan terlihat oleh pendaftar dalam pengumuman</div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Keputusan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}
.avatar-lg {
    width: 60px;
    height: 60px;
}
.empty-state {
    padding: 2rem;
}
.card {
    transition: all 0.3s ease;
}
.table th {
    font-weight: 600;
    color: #495057;
    background-color: #f8f9fa;
}
.badge {
    font-weight: 500;
}
</style>

<script>
function buatKeputusan(id, nama) {
    document.getElementById('pendaftar_id').value = id;
    document.getElementById('nama_pendaftar').textContent = nama;
    document.querySelector('[name="hasil_keputusan"]').value = '';
    document.querySelector('[name="catatan_keputusan"]').value = '';
    new bootstrap.Modal(document.getElementById('keputusanModal')).show();
}

function lihatDetail(id) {
    window.location.href = `/admin/monitoring/${id}`;
}

function exportKeputusan() {
    window.location.href = '/admin/keputusan/export';
}

// Search and Filter
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#keputusanTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

document.getElementById('filterStatus').addEventListener('change', function() {
    const filter = this.value;
    const rows = document.querySelectorAll('#keputusanTable tbody tr');
    
    rows.forEach(row => {
        if (!filter) {
            row.style.display = '';
            return;
        }
        
        const keputusanCell = row.cells[5];
        const badge = keputusanCell.querySelector('.badge');
        
        if (!badge) return;
        
        const badgeText = badge.textContent.toLowerCase();
        let show = false;
        
        switch(filter) {
            case 'siap':
                show = badgeText.includes('belum diputuskan');
                break;
            case 'lulus':
                show = badgeText.includes('lulus') && !badgeText.includes('tidak');
                break;
            case 'tidak_lulus':
                show = badgeText.includes('tidak lulus');
                break;
            case 'cadangan':
                show = badgeText.includes('cadangan');
                break;
        }
        
        row.style.display = show ? '' : 'none';
    });
});

// Form submission
document.getElementById('keputusanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    const formData = new FormData(this);
    
    fetch('{{ route("admin.keputusan.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('keputusanModal')).hide();
            
            // Show success toast
            const toast = document.createElement('div');
            toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3';
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i>Keputusan berhasil disimpan
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            document.body.appendChild(toast);
            
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            setTimeout(() => location.reload(), 1500);
        } else {
            alert('Terjadi kesalahan: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan koneksi');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});
</script>
@endsection