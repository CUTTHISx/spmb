@extends('layouts.main')

@section('title', 'Keputusan PPDB - Admin')

@section('content')
<div class="container-fluid mt-4">


    <!-- Stats Overview -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold">{{ $stats['siap_keputusan'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Siap Keputusan</p>
                        </div>
                        <div class="stat-icon bg-warning-light">
                            <i class="fas fa-clock text-warning fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold">{{ $stats['lulus'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Lulus</p>
                        </div>
                        <div class="stat-icon bg-success-light">
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold">{{ $stats['tidak_lulus'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Tidak Lulus</p>
                        </div>
                        <div class="stat-icon bg-danger-light">
                            <i class="fas fa-times-circle text-danger fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold">{{ $stats['cadangan'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Cadangan</p>
                        </div>
                        <div class="stat-icon bg-info-light">
                            <i class="fas fa-list text-info fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card system-status-card">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-gavel text-primary me-2"></i>
                    Keputusan PPDB
                </h5>

            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Filter Status</label>
                    <select class="form-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="siap">Siap Keputusan</option>
                        <option value="lulus">Lulus</option>
                        <option value="tidak_lulus">Tidak Lulus</option>
                        <option value="cadangan">Cadangan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cari Data</label>
                    <input type="text" class="form-control" placeholder="Nama/No Pendaftaran" id="searchInput">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="keputusanTable">
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

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title fw-semibold">
                    <i class="fas fa-info-circle me-2"></i>Detail Pendaftar
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Data Pribadi</h6>
                        <table class="table table-sm">
                            <tr><td class="fw-semibold">No. Pendaftaran</td><td id="detail_no_pendaftaran">-</td></tr>
                            <tr><td class="fw-semibold">Nama Lengkap</td><td id="detail_nama">-</td></tr>
                            <tr><td class="fw-semibold">NISN</td><td id="detail_nisn">-</td></tr>
                            <tr><td class="fw-semibold">NIK</td><td id="detail_nik">-</td></tr>
                            <tr><td class="fw-semibold">Jenis Kelamin</td><td id="detail_jk">-</td></tr>
                            <tr><td class="fw-semibold">Tempat, Tgl Lahir</td><td id="detail_lahir">-</td></tr>
                            <tr><td class="fw-semibold">Alamat</td><td id="detail_alamat">-</td></tr>
                            <tr><td class="fw-semibold">Wilayah</td><td id="detail_wilayah">-</td></tr>
                            <tr><td class="fw-semibold">Jurusan</td><td id="detail_jurusan">-</td></tr>
                            <tr><td class="fw-semibold">Tanggal Daftar</td><td id="detail_tgl_daftar">-</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Data Orang Tua & Sekolah</h6>
                        <table class="table table-sm">
                            <tr><td class="fw-semibold">Nama Ayah</td><td id="detail_ayah">-</td></tr>
                            <tr><td class="fw-semibold">HP Ayah</td><td id="detail_hp_ayah">-</td></tr>
                            <tr><td class="fw-semibold">Nama Ibu</td><td id="detail_ibu">-</td></tr>
                            <tr><td class="fw-semibold">HP Ibu</td><td id="detail_hp_ibu">-</td></tr>
                            <tr><td class="fw-semibold">Asal Sekolah</td><td id="detail_sekolah">-</td></tr>
                            <tr><td class="fw-semibold">NPSN</td><td id="detail_npsn">-</td></tr>
                            <tr><td class="fw-semibold">Nilai Rata-rata</td><td id="detail_nilai">-</td></tr>
                        </table>
                        <h6 class="fw-bold mb-3 mt-4">Status Pembayaran</h6>
                        <table class="table table-sm">
                            <tr><td class="fw-semibold">Nominal</td><td id="detail_nominal">-</td></tr>
                            <tr><td class="fw-semibold">Status</td><td id="detail_status_bayar">-</td></tr>
                        </table>
                    </div>
                </div>
                <h6 class="fw-bold mb-3 mt-3">Status Keputusan</h6>
                <div class="alert alert-light border" id="detail_keputusan">
                    <div class="d-flex align-items-center">
                        <div class="me-3" id="detail_keputusan_icon"></div>
                        <div>
                            <h6 class="mb-1 fw-semibold" id="detail_keputusan_text">Belum Ada Keputusan</h6>
                            <p class="mb-0 text-muted" id="detail_keputusan_tgl">-</p>
                        </div>
                    </div>
                </div>
                <h6 class="fw-bold mb-3">Berkas</h6>
                <div class="row" id="detail_berkas"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Berkas -->
<div class="modal fade" id="previewBerkasModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-semibold" id="previewBerkasTitle">
                    <i class="fas fa-file-image me-2"></i>Preview Berkas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 text-center bg-dark">
                <img id="previewBerkasImage" src="" class="img-fluid" style="max-height: 70vh; width: auto;">
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
    border-radius: 12px;
}
.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}
.table th {
    font-weight: 600;
    color: #495057;
    background-color: #f8f9fa;
    border: none;
    padding: 1rem 0.75rem;
}
.table td {
    padding: 1rem 0.75rem;
    border-color: #f1f3f4;
}
.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}
.bg-gradient-danger {
    background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
}
.btn {
    border-radius: 8px;
    font-weight: 500;
    padding: 0.5rem 1rem;
}
.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e3e6f0;
}
.modal-content {
    border-radius: 12px;
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
    fetch(`/admin/keputusan/${id}`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                const data = result.data;
                
                // Data Pribadi
                document.getElementById('detail_no_pendaftaran').textContent = data.no_pendaftaran;
                document.getElementById('detail_nama').textContent = data.nama;
                document.getElementById('detail_nisn').textContent = data.nisn;
                document.getElementById('detail_nik').textContent = data.nik;
                document.getElementById('detail_jk').textContent = data.jk === 'L' ? 'Laki-laki' : 'Perempuan';
                document.getElementById('detail_lahir').textContent = `${data.tmp_lahir}, ${data.tgl_lahir}`;
                document.getElementById('detail_alamat').textContent = data.alamat;
                document.getElementById('detail_wilayah').textContent = data.wilayah;
                document.getElementById('detail_jurusan').textContent = data.jurusan;
                document.getElementById('detail_tgl_daftar').textContent = data.tgl_daftar;
                
                // Data Orang Tua & Sekolah
                document.getElementById('detail_ayah').textContent = data.nama_ayah;
                document.getElementById('detail_hp_ayah').textContent = data.hp_ayah;
                document.getElementById('detail_ibu').textContent = data.nama_ibu;
                document.getElementById('detail_hp_ibu').textContent = data.hp_ibu;
                document.getElementById('detail_sekolah').textContent = data.asal_sekolah;
                document.getElementById('detail_npsn').textContent = data.npsn;
                document.getElementById('detail_nilai').textContent = data.nilai_rata;
                
                // Pembayaran
                document.getElementById('detail_nominal').textContent = 'Rp ' + parseInt(data.nominal_bayar).toLocaleString('id-ID');
                const statusBayar = data.status_bayar === 'VERIFIED' ? 
                    '<span class="badge bg-success">Terverifikasi</span>' : 
                    '<span class="badge bg-warning">Menunggu</span>';
                document.getElementById('detail_status_bayar').innerHTML = statusBayar;
                
                // Status Keputusan
                const keputusanEl = document.getElementById('detail_keputusan');
                const iconEl = document.getElementById('detail_keputusan_icon');
                const textEl = document.getElementById('detail_keputusan_text');
                const tglEl = document.getElementById('detail_keputusan_tgl');
                
                if (data.hasil_keputusan) {
                    if (data.hasil_keputusan === 'LULUS') {
                        keputusanEl.className = 'alert alert-success border-success';
                        iconEl.innerHTML = '<i class="fas fa-check-circle fa-3x text-success"></i>';
                        textEl.textContent = 'LULUS';
                    } else if (data.hasil_keputusan === 'TIDAK_LULUS') {
                        keputusanEl.className = 'alert alert-danger border-danger';
                        iconEl.innerHTML = '<i class="fas fa-times-circle fa-3x text-danger"></i>';
                        textEl.textContent = 'TIDAK LULUS';
                    } else {
                        keputusanEl.className = 'alert alert-info border-info';
                        iconEl.innerHTML = '<i class="fas fa-list fa-3x text-info"></i>';
                        textEl.textContent = 'CADANGAN';
                    }
                    tglEl.textContent = data.tgl_keputusan || '-';
                } else {
                    keputusanEl.className = 'alert alert-light border';
                    iconEl.innerHTML = '<i class="fas fa-clock fa-3x text-muted"></i>';
                    textEl.textContent = 'Belum Ada Keputusan';
                    tglEl.textContent = '-';
                }
                
                // Berkas
                const berkasContainer = document.getElementById('detail_berkas');
                berkasContainer.innerHTML = '';
                data.berkas.forEach(b => {
                    const statusClass = b.status === 'VERIFIED' ? 'success' : 'warning';
                    const jenisLabel = {
                        'IJAZAH': 'Ijazah',
                        'KK': 'Kartu Keluarga',
                        'AKTA': 'Akta Kelahiran',
                        'KIP': 'Kartu Indonesia Pintar',
                        'LAINNYA': 'Dokumen Lainnya'
                    }[b.jenis] || b.jenis;
                    
                    berkasContainer.innerHTML += `
                        <div class="col-md-3 mb-2">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-file fa-2x text-primary mb-2"></i>
                                    <h6 class="mb-1">${b.jenis}</h6>
                                    <small class="text-muted">${b.ukuran_kb} KB</small>
                                    <div class="mt-2">
                                        <span class="badge bg-${statusClass}">${b.status}</span>
                                    </div>
                                    <button onclick="previewBerkas('/${b.url}', '${jenisLabel}')" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="fas fa-eye"></i> Lihat
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                new bootstrap.Modal(document.getElementById('detailModal')).show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat detail');
        });
}

function exportKeputusan() {
    window.location.href = '/admin/keputusan/export';
}

function kirimNotifikasi() {
    if(confirm('Kirim notifikasi email ke semua pendaftar yang sudah ada keputusan?')) {
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
        btn.disabled = true;
        
        fetch('/admin/keputusan/kirim-notifikasi', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Notifikasi berhasil dikirim ke ' + data.count + ' pendaftar');
            } else {
                alert('Gagal mengirim notifikasi: ' + data.message);
            }
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
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

function previewBerkas(url, jenis) {
    document.getElementById('previewBerkasTitle').innerHTML = `<i class="fas fa-file-image me-2"></i>${jenis}`;
    document.getElementById('previewBerkasImage').src = url;
    new bootstrap.Modal(document.getElementById('previewBerkasModal')).show();
}

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