@extends('layouts.main')

@section('title', 'Verifikasi Pembayaran - PPDB Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/layouts/dashboard.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-white bg-opacity-20 rounded-circle p-3">
                                <i class="fas fa-receipt fa-2x"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">Verifikasi Pembayaran</h2>
                            <p class="mb-0 opacity-90">Periksa dan konfirmasi bukti pembayaran pendaftar PPDB</p>
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
                        Daftar Pembayaran
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-bold">Pendaftar</th>
                                    <th class="border-0 fw-bold">Nominal</th>
                                    <th class="border-0 fw-bold">Tanggal</th>
                                    <th class="border-0 fw-bold">Metode</th>
                                    <th class="border-0 fw-bold">Status</th>
                                    <th class="border-0 fw-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftar as $p)
                                <tr data-id="{{ $p->id }}">
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary-light rounded-circle p-2 me-3">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $p->dataSiswa->nama ?? $p->user->name ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $p->no_pendaftaran ?? 'PPDB'.date('Y').str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-success">Rp {{ number_format($p->pembayaran->nominal ?? 0, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <div>{{ $p->created_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $p->created_at->format('H:i') }} WIB</small>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-info-light text-info">Transfer Bank</span>
                                    </td>
                                    <td class="py-3 status-cell">
                                        @if($p->pembayaran)
                                            @switch($p->pembayaran->status_verifikasi ?? 'PENDING')
                                                @case('VERIFIED')
                                                    <span class="badge bg-success">Terverifikasi</span>
                                                    @break
                                                @case('REJECTED')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                            @endswitch
                                        @else
                                            <span class="badge bg-secondary">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center action-cell">
                                        @if($p->pembayaran && $p->pembayaran->status_verifikasi == 'VERIFIED')
                                            <span class="badge bg-success-light text-success">
                                                <i class="fas fa-check-circle me-1"></i>Selesai
                                            </span>
                                        @elseif($p->pembayaran && $p->pembayaran->status_verifikasi == 'REJECTED')
                                            <span class="badge bg-danger-light text-danger">
                                                <i class="fas fa-times-circle me-1"></i>Ditolak
                                            </span>
                                        @elseif($p->pembayaran)
                                            <div class="d-flex gap-1 justify-content-center">
                                                <span class="badge bg-success-light text-success" style="cursor: pointer;" onclick="updatePayment({{ $p->id }}, 'LUNAS')" title="Terima">
                                                    <i class="fas fa-check me-1"></i>Terima
                                                </span>
                                                <span class="badge bg-danger-light text-danger" style="cursor: pointer;" onclick="updatePayment({{ $p->id }}, 'DITOLAK')" title="Tolak">
                                                    <i class="fas fa-times me-1"></i>Tolak
                                                </span>
                                                <span class="badge bg-info-light text-info" style="cursor: pointer;" onclick="viewProof({{ $p->id }})" title="Lihat">
                                                    <i class="fas fa-eye me-1"></i>Lihat
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-muted small">Belum upload bukti</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
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

<!-- Modal Lihat Bukti -->
<div class="modal fade" id="proofModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="proofImage" src="" class="img-fluid" style="max-height: 500px;">
            </div>
        </div>
    </div>
</div>

<!-- Modal Catatan -->
<div class="modal fade" id="noteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Catatan Verifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="noteForm">
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan:</label>
                        <textarea class="form-control" id="catatan" rows="3" placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="submitRejection()">Tolak Pembayaran</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentPaymentId = null;

function updatePayment(id, status) {
    if (status === 'DITOLAK') {
        currentPaymentId = id;
        new bootstrap.Modal(document.getElementById('noteModal')).show();
        return;
    }
    
    if (confirm('Yakin ingin memverifikasi pembayaran ini?')) {
        submitPaymentUpdate(id, status, '');
    }
}

function submitRejection() {
    const catatan = document.getElementById('catatan').value;
    if (!catatan.trim()) {
        alert('Harap masukkan alasan penolakan');
        return;
    }
    
    submitPaymentUpdate(currentPaymentId, 'DITOLAK', catatan);
    bootstrap.Modal.getInstance(document.getElementById('noteModal')).hide();
}

function submitPaymentUpdate(id, status, catatan) {
    fetch(`/keuangan/payment/${id}`, {
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
            updateRowStatus(id, status);
        } else {
            alert('Error: ' + data.message);
        }
    });
}

function updateRowStatus(id, status) {
    const row = document.querySelector(`tr[data-id="${id}"]`);
    if (!row) return;
    
    const statusCell = row.querySelector('.status-cell');
    const actionCell = row.querySelector('.action-cell');
    
    if (status === 'LUNAS') {
        statusCell.innerHTML = '<span class="badge bg-success">Terverifikasi</span>';
        actionCell.innerHTML = '<span class="badge bg-success-light text-success"><i class="fas fa-check-circle me-1"></i>Selesai</span>';
    } else if (status === 'DITOLAK') {
        statusCell.innerHTML = '<span class="badge bg-danger">Ditolak</span>';
        actionCell.innerHTML = '<span class="badge bg-danger-light text-danger"><i class="fas fa-times-circle me-1"></i>Ditolak</span>';
    }
}

function viewProof(id) {
    // Get payment data
    fetch(`/keuangan/payment-proof/${id}`)
    .then(response => response.json())
    .then(data => {
        if (data.success && data.bukti_url) {
            document.getElementById('proofImage').src = data.bukti_url;
            document.getElementById('proofImage').onerror = function() {
                this.src = 'https://via.placeholder.com/400x300?text=Gambar+Tidak+Ditemukan';
            };
            new bootstrap.Modal(document.getElementById('proofModal')).show();
        } else {
            alert('Bukti pembayaran tidak ditemukan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading payment proof');
    });
}
</script>
@endsection