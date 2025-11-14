@extends('layouts.main')

@section('title', 'Verifikasi Administrasi - PPDB Online')

@section('content')
<div class="container mt-4">
    <div class="card system-status-card">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Verifikasi Administrasi</h4>
                    <p class="text-muted mb-0">Verifikasi data dan berkas pendaftar</p>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="form-label">Status Verifikasi</label>
                    <select class="form-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="menunggu">Menunggu Verifikasi</option>
                        <option value="lulus">Lulus</option>
                        <option value="tolak">Ditolak</option>
                        <option value="perbaikan">Perlu Perbaikan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jurusan</label>
                    <select class="form-select" id="filterJurusan">
                        <option value="">Semua Jurusan</option>
                        <option value="TI">Teknik Informatika</option>
                        <option value="SI">Sistem Informasi</option>
                        <option value="TKJ">Teknik Komputer Jaringan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cari Pendaftar</label>
                    <input type="text" class="form-control" id="searchPendaftar" placeholder="Nama/NISN/No. Daftar">
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center py-3">
                            <i class="fas fa-clock fa-2x mb-2"></i>
                            <h4>{{ $menungguVerifikasi ?? 34 }}</h4>
                            <small>Menunggu Verifikasi</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center py-3">
                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                            <h4>{{ $lulus ?? 89 }}</h4>
                            <small>Lulus Verifikasi</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center py-3">
                            <i class="fas fa-times-circle fa-2x mb-2"></i>
                            <h4>{{ $ditolak ?? 12 }}</h4>
                            <small>Ditolak</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center py-3">
                            <i class="fas fa-edit fa-2x mb-2"></i>
                            <h4>{{ $perbaikan ?? 21 }}</h4>
                            <small>Perlu Perbaikan</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-hover" id="verifikasiTable">
                    <thead class="table-light">
                        <tr>
                            <th>No. Daftar</th>
                            <th>Nama Lengkap</th>
                            <th>Jurusan</th>
                            <th>Status Verifikasi</th>
                            <th>Tgl Submit</th>
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
                            <td>
                                <span class="badge bg-info">{{ ['Teknik Informatika', 'Sistem Informasi', 'TKJ'][($i-1) % 3] }}</span>
                            </td>
                            <td>
                                @php
                                    $statuses = ['menunggu', 'lulus', 'tolak', 'perbaikan'];
                                    $colors = ['warning', 'success', 'danger', 'info'];
                                    $labels = ['Menunggu', 'Lulus', 'Ditolak', 'Perbaikan'];
                                    $statusIndex = ($i-1) % 4;
                                @endphp
                                <span class="badge bg-{{ $colors[$statusIndex] }}">{{ $labels[$statusIndex] }}</span>
                            </td>
                            <td>{{ date('d/m/Y', strtotime('-'.rand(1,15).' days')) }}</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm" onclick="verifikasiDetail({{ $i }})" title="Verifikasi">
                                    <i class="fas fa-search"></i> Verifikasi
                                </button>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Verifikasi Modal -->
<div class="modal fade" id="verifikasiModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi Administrasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Data Pendaftar</h6>
                        <table class="table table-sm">
                            <tr><td>No. Daftar</td><td id="verifikasiNoDaftar">-</td></tr>
                            <tr><td>Nama</td><td id="verifikasiNama">-</td></tr>
                            <tr><td>NISN</td><td id="verifikasiNisn">-</td></tr>
                            <tr><td>Jurusan</td><td id="verifikasiJurusan">-</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Kelengkapan Data</h6>
                        <div id="verifikasiData">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Data Pribadi</span>
                                <span class="badge bg-success">✓ Lengkap</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Data Orang Tua</span>
                                <span class="badge bg-success">✓ Lengkap</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Data Asal Sekolah</span>
                                <span class="badge bg-warning">⚠ Perlu Cek</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-12">
                        <h6>Keputusan Verifikasi</h6>
                        <div class="mb-3">
                            <label class="form-label">Status Verifikasi</label>
                            <select class="form-select" id="statusVerifikasi">
                                <option value="lulus">Lulus</option>
                                <option value="tolak">Tolak</option>
                                <option value="perbaikan">Perlu Perbaikan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan Verifikasi</label>
                            <textarea class="form-control" id="catatanVerifikasi" rows="3" placeholder="Berikan catatan untuk pendaftar..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpanVerifikasi()">Simpan Verifikasi</button>
            </div>
        </div>
    </div>
</div>

<script>
function verifikasiDetail(id) {
    document.getElementById('verifikasiNoDaftar').textContent = 'PPDB2024' + String(id).padStart(4, '0');
    document.getElementById('verifikasiNama').textContent = 'Ahmad Rizki Pratama';
    document.getElementById('verifikasiNisn').textContent = '1234567890';
    document.getElementById('verifikasiJurusan').textContent = 'Teknik Informatika';
    
    new bootstrap.Modal(document.getElementById('verifikasiModal')).show();
}

function simpanVerifikasi() {
    const status = document.getElementById('statusVerifikasi').value;
    const catatan = document.getElementById('catatanVerifikasi').value;
    
    if(!catatan.trim()) {
        alert('Catatan verifikasi harus diisi');
        return;
    }
    
    alert(`Verifikasi berhasil disimpan dengan status: ${status}`);
    bootstrap.Modal.getInstance(document.getElementById('verifikasiModal')).hide();
}
</script>
@endsection