@extends('layouts.main')

@section('title', 'Verifikasi Pembayaran - PPDB Online')

@section('content')
<div class="container mt-4">
    <div class="card system-status-card">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Verifikasi Pembayaran</h4>
                    <p class="text-muted mb-0">Validasi bukti pembayaran pendaftar</p>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="form-label">Status Pembayaran</label>
                    <select class="form-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="menunggu">Menunggu Verifikasi</option>
                        <option value="lunas">Terbayar</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="belum_bayar">Belum Bayar</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select class="form-select" id="filterMetode">
                        <option value="">Semua Metode</option>
                        <option value="transfer">Transfer Bank</option>
                        <option value="va">Virtual Account</option>
                        <option value="tunai">Tunai</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cari Pendaftar</label>
                    <input type="text" class="form-control" id="searchPendaftar" placeholder="Nama/No. Daftar/No. Transaksi">
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center py-3">
                            <i class="fas fa-clock fa-2x mb-2"></i>
                            <h4>{{ $menungguVerifikasi ?? 28 }}</h4>
                            <small>Menunggu Verifikasi</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center py-3">
                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                            <h4>{{ $terbayar ?? 98 }}</h4>
                            <small>Terbayar</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center py-3">
                            <i class="fas fa-times-circle fa-2x mb-2"></i>
                            <h4>{{ $ditolak ?? 8 }}</h4>
                            <small>Ditolak</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-secondary text-white">
                        <div class="card-body text-center py-3">
                            <i class="fas fa-money-bill fa-2x mb-2"></i>
                            <h4>{{ $belumBayar ?? 22 }}</h4>
                            <small>Belum Bayar</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-hover" id="pembayaranTable">
                    <thead class="table-light">
                        <tr>
                            <th>No. Daftar</th>
                            <th>Nama Lengkap</th>
                            <th>Jumlah Bayar</th>
                            <th>Metode</th>
                            <th>Status Bayar</th>
                            <th>Tgl Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 15; $i++)
                        <tr>
                            <td>
                                <span class="badge bg-primary">PPDB{{ date('Y') }}{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="fw-medium">{{ ['Ahmad Rizki', 'Siti Nurhaliza', 'Budi Santoso', 'Dewi Sartika', 'Andi Wijaya'][($i-1) % 5] }}</td>
                            <td class="fw-bold text-success">Rp {{ number_format([200000, 250000, 300000][($i-1) % 3], 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $metodes = ['Transfer Bank', 'Virtual Account', 'Tunai'];
                                    $metode = $metodes[($i-1) % 3];
                                @endphp
                                <span class="badge bg-info">{{ $metode }}</span>
                            </td>
                            <td>
                                @php
                                    $statuses = ['menunggu', 'lunas', 'ditolak', 'belum_bayar'];
                                    $colors = ['warning', 'success', 'danger', 'secondary'];
                                    $labels = ['Menunggu', 'Terbayar', 'Ditolak', 'Belum Bayar'];
                                    $statusIndex = ($i-1) % 4;
                                @endphp
                                <span class="badge bg-{{ $colors[$statusIndex] }}">{{ $labels[$statusIndex] }}</span>
                            </td>
                            <td>{{ date('d/m/Y H:i', strtotime('-'.rand(1,7).' days')) }}</td>
                            <td>
                                @if($statusIndex == 0)
                                <button class="btn btn-outline-primary btn-sm" onclick="verifikasiBayar({{ $i }})" title="Verifikasi">
                                    <i class="fas fa-search"></i> Verifikasi
                                </button>
                                @else
                                <button class="btn btn-outline-secondary btn-sm" onclick="lihatBukti({{ $i }})" title="Lihat Bukti">
                                    <i class="fas fa-eye"></i> Lihat
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Verifikasi Pembayaran Modal -->
<div class="modal fade" id="verifikasiBayarModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Data Pembayaran</h6>
                        <table class="table table-sm">
                            <tr><td>No. Daftar</td><td id="bayarNoDaftar">-</td></tr>
                            <tr><td>Nama</td><td id="bayarNama">-</td></tr>
                            <tr><td>Jumlah Bayar</td><td id="bayarJumlah">-</td></tr>
                            <tr><td>Metode</td><td id="bayarMetode">-</td></tr>
                            <tr><td>No. Transaksi</td><td id="bayarTransaksi">-</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Bukti Pembayaran</h6>
                        <div class="text-center">
                            <img src="https://via.placeholder.com/300x200?text=Bukti+Transfer" class="img-fluid border rounded" alt="Bukti Pembayaran">
                            <p class="mt-2 text-muted">Klik untuk memperbesar</p>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-12">
                        <h6>Keputusan Verifikasi</h6>
                        <div class="mb-3">
                            <label class="form-label">Status Pembayaran</label>
                            <select class="form-select" id="statusPembayaran">
                                <option value="lunas">Terbayar (Valid)</option>
                                <option value="ditolak">Ditolak (Invalid)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alasan/Catatan</label>
                            <textarea class="form-control" id="catatanPembayaran" rows="3" placeholder="Berikan alasan jika ditolak atau catatan tambahan..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpanVerifikasiBayar()">Simpan Verifikasi</button>
            </div>
        </div>
    </div>
</div>

<script>
function verifikasiBayar(id) {
    document.getElementById('bayarNoDaftar').textContent = 'PPDB2024' + String(id).padStart(4, '0');
    document.getElementById('bayarNama').textContent = 'Ahmad Rizki Pratama';
    document.getElementById('bayarJumlah').textContent = 'Rp 250.000';
    document.getElementById('bayarMetode').textContent = 'Transfer Bank';
    document.getElementById('bayarTransaksi').textContent = 'TRX' + Date.now();
    
    new bootstrap.Modal(document.getElementById('verifikasiBayarModal')).show();
}

function lihatBukti(id) {
    alert('Menampilkan bukti pembayaran untuk pendaftar ID: ' + id);
}

function simpanVerifikasiBayar() {
    const status = document.getElementById('statusPembayaran').value;
    const catatan = document.getElementById('catatanPembayaran').value;
    
    if(status === 'ditolak' && !catatan.trim()) {
        alert('Alasan penolakan harus diisi');
        return;
    }
    
    alert(`Verifikasi pembayaran berhasil disimpan dengan status: ${status}`);
    bootstrap.Modal.getInstance(document.getElementById('verifikasiBayarModal')).hide();
}
</script>
@endsection