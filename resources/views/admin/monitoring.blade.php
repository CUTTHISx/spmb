@extends('layouts.main')

@section('title', 'Monitoring Berkas - PPDB Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/layouts/dashboard.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <!-- Stats Overview -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold">{{ $totalPendaftar ?? 156 }}</h3>
                            <p class="text-muted mb-0">Total Pendaftar</p>
                        </div>
                        <div class="stat-icon bg-primary-light">
                            <i class="fas fa-users text-primary fa-lg"></i>
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
                            <h3 class="fw-bold">{{ $berkasLengkap ?? 89 }}</h3>
                            <p class="text-muted mb-0">Berkas Lengkap</p>
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
                            <h3 class="fw-bold">{{ $menungguVerifikasi ?? 34 }}</h3>
                            <p class="text-muted mb-0">Menunggu Verifikasi</p>
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
                            <h3 class="fw-bold">{{ $berkasKurang ?? 33 }}</h3>
                            <p class="text-muted mb-0">Berkas Kurang</p>
                        </div>
                        <div class="stat-icon bg-danger-light">
                            <i class="fas fa-exclamation-triangle text-danger fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card system-status-card">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-1 fw-bold">
                        <i class="fas fa-folder-open text-primary me-2"></i>
                        Monitoring Berkas Pendaftar
                    </h5>
                    <p class="text-muted mb-0">Kelola dan verifikasi kelengkapan berkas pendaftar</p>
                </div>

            </div>
        </div>
        
        <div class="card-body">
            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label">Filter Jurusan</label>
                    <select class="form-select" id="filterJurusan">
                        <option value="">Semua Jurusan</option>
                        <option value="PPLG">PPLG</option>
                        <option value="AKUNTANSI">Akuntansi</option>
                        <option value="DKV">DKV</option>
                        <option value="ANIMASI">Animasi</option>
                        <option value="BDP">BDP</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status Berkas</label>
                    <select class="form-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="lengkap">Lengkap</option>
                        <option value="tidak_lengkap">Tidak Lengkap</option>
                        <option value="menunggu">Menunggu Verifikasi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cari Pendaftar</label>
                    <input type="text" class="form-control" id="searchPendaftar" placeholder="Nama/NISN/No. Daftar">
                </div>
            </div>



            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-hover" id="monitoringTable">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>No. Daftar</th>
                            <th>Nama Lengkap</th>
                            <th>NISN</th>
                            <th>Jurusan</th>
                            <th>Kelengkapan Berkas</th>
                            <th>Status</th>
                            <th>Tgl Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftar as $p)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input row-checkbox" value="{{ $p->id }}">
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $p->no_pendaftaran ?? 'PPDB'.date('Y').str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="fw-medium">{{ $p->dataSiswa->nama ?? $p->user->name ?? 'N/A' }}</td>
                            <td>{{ $p->dataSiswa->nisn ?? '-' }}</td>
                            <td>
                                @if($p->jurusan)
                                    <span class="badge bg-info">{{ $p->jurusan->nama }}</span>
                                @else
                                    <span class="badge bg-secondary">Belum Pilih</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $completeness = 0;
                                    if($p->dataSiswa) $completeness += 30;
                                    if($p->dataOrtu) $completeness += 25;
                                    if($p->asalSekolah) $completeness += 25;
                                    if($p->berkas()->count() > 0) $completeness += 20;
                                    
                                    $color = $completeness >= 90 ? 'success' : ($completeness >= 70 ? 'warning' : 'danger');
                                @endphp
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-{{ $color }}" style="width: {{ $completeness }}%">
                                        {{ $completeness }}%
                                    </div>
                                </div>
                                <small class="text-muted">{{ $p->berkas()->count() }}/6 berkas</small>
                            </td>
                            <td>
                                @switch($p->status)
                                    @case('VERIFIED_ADM')
                                        <span class="badge bg-success">Terverifikasi</span>
                                        @break
                                    @case('SUBMITTED')
                                        <span class="badge bg-warning">Menunggu</span>
                                        @break
                                    @case('REJECTED')
                                        <span class="badge bg-danger">Ditolak</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">Draft</span>
                                @endswitch
                            </td>
                            <td>{{ $p->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-primary btn-sm" onclick="viewDetail({{ $p->id }})" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-info btn-sm" onclick="downloadBerkas({{ $p->id }})" title="Download Berkas">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data pendaftar</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($pendaftar) && method_exists($pendaftar, 'links'))
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <small class="text-muted">
                        Menampilkan {{ $pendaftar->firstItem() ?? 1 }}-{{ $pendaftar->lastItem() ?? $pendaftar->count() }} 
                        dari {{ $pendaftar->total() }} data
                    </small>
                </div>
                <div>
                    {{ $pendaftar->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Lengkap Pendaftar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="detailTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab">
                            <i class="fas fa-user me-2"></i>Data Pribadi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ortu-tab" data-bs-toggle="tab" data-bs-target="#ortu" type="button" role="tab">
                            <i class="fas fa-users me-2"></i>Data Orang Tua
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sekolah-tab" data-bs-toggle="tab" data-bs-target="#sekolah" type="button" role="tab">
                            <i class="fas fa-school me-2"></i>Asal Sekolah
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="berkas-tab" data-bs-toggle="tab" data-bs-target="#berkas" type="button" role="tab">
                            <i class="fas fa-folder me-2"></i>Berkas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pembayaran-tab" data-bs-toggle="tab" data-bs-target="#pembayaran" type="button" role="tab">
                            <i class="fas fa-credit-card me-2"></i>Pembayaran
                        </button>
                    </li>
                </ul>
                
                <!-- Tab panes -->
                <div class="tab-content mt-3" id="detailTabContent">
                    <!-- Data Pribadi -->
                    <div class="tab-pane fade show active" id="data" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr><td class="fw-medium">No. Pendaftaran</td><td id="detailNoDaftar">-</td></tr>
                                    <tr><td class="fw-medium">Nama Lengkap</td><td id="detailNama">-</td></tr>
                                    <tr><td class="fw-medium">NISN</td><td id="detailNisn">-</td></tr>
                                    <tr><td class="fw-medium">NIK</td><td id="detailNik">-</td></tr>
                                    <tr><td class="fw-medium">Jenis Kelamin</td><td id="detailJk">-</td></tr>
                                    <tr><td class="fw-medium">Tempat Lahir</td><td id="detailTmpLahir">-</td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr><td class="fw-medium">Tanggal Lahir</td><td id="detailTglLahir">-</td></tr>
                                    <tr><td class="fw-medium">Alamat</td><td id="detailAlamat">-</td></tr>
                                    <tr><td class="fw-medium">Wilayah</td><td id="detailWilayah">-</td></tr>
                                    <tr><td class="fw-medium">Jurusan Pilihan</td><td id="detailJurusan">-</td></tr>
                                    <tr><td class="fw-medium">Status</td><td id="detailStatus">-</td></tr>
                                    <tr><td class="fw-medium">Tanggal Daftar</td><td id="detailTglDaftar">-</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Data Orang Tua -->
                    <div class="tab-pane fade" id="ortu" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">Data Ayah</h6>
                                <table class="table table-sm">
                                    <tr><td class="fw-medium">Nama Ayah</td><td id="detailNamaAyah">-</td></tr>
                                    <tr><td class="fw-medium">No. HP Ayah</td><td id="detailHpAyah">-</td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary">Data Ibu</h6>
                                <table class="table table-sm">
                                    <tr><td class="fw-medium">Nama Ibu</td><td id="detailNamaIbu">-</td></tr>
                                    <tr><td class="fw-medium">No. HP Ibu</td><td id="detailHpIbu">-</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Asal Sekolah -->
                    <div class="tab-pane fade" id="sekolah" role="tabpanel">
                        <table class="table table-sm">
                            <tr><td class="fw-medium">Nama Sekolah</td><td id="detailAsalSekolah">-</td></tr>
                            <tr><td class="fw-medium">NPSN</td><td id="detailNpsn">-</td></tr>
                            <tr><td class="fw-medium">Nilai Rata-rata</td><td id="detailNilaiRata">-</td></tr>
                        </table>
                    </div>
                    
                    <!-- Berkas -->
                    <div class="tab-pane fade" id="berkas" role="tabpanel">
                        <div id="detailBerkas">
                            <!-- Berkas akan dimuat via JavaScript -->
                        </div>
                    </div>
                    
                    <!-- Pembayaran -->
                    <div class="tab-pane fade" id="pembayaran" role="tabpanel">
                        <table class="table table-sm">
                            <tr><td class="fw-medium">Nominal Pembayaran</td><td id="detailNominalBayar">-</td></tr>
                            <tr><td class="fw-medium">Status Pembayaran</td><td id="detailStatusBayar">-</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="printDetail()">Cetak Detail</button>
            </div>
        </div>
    </div>
</div>

<script>
// Filter and Search Functions
document.getElementById('filterJurusan').addEventListener('change', filterTable);
document.getElementById('filterStatus').addEventListener('change', filterTable);
document.getElementById('searchPendaftar').addEventListener('input', filterTable);

function filterTable() {
    const jurusanFilter = document.getElementById('filterJurusan').value.toLowerCase();
    const statusFilter = document.getElementById('filterStatus').value.toLowerCase();
    const searchTerm = document.getElementById('searchPendaftar').value.toLowerCase();
    
    const rows = document.querySelectorAll('#monitoringTable tbody tr');
    
    rows.forEach(row => {
        const jurusan = row.cells[4]?.textContent.toLowerCase() || '';
        const status = row.cells[6]?.textContent.toLowerCase() || '';
        const noDaftar = row.cells[1]?.textContent.toLowerCase() || '';
        const nama = row.cells[2]?.textContent.toLowerCase() || '';
        const nisn = row.cells[3]?.textContent.toLowerCase() || '';
        
        // Convert status filter to match display text
        let statusMatch = true;
        if (statusFilter) {
            if (statusFilter === 'lengkap' && !status.includes('terverifikasi')) statusMatch = false;
            else if (statusFilter === 'menunggu' && !status.includes('menunggu')) statusMatch = false;
            else if (statusFilter === 'tidak_lengkap' && !(status.includes('draft') || status.includes('kurang'))) statusMatch = false;
        }
        
        const jurusanMatch = !jurusanFilter || jurusan.includes(jurusanFilter);
        const searchMatch = !searchTerm || nama.includes(searchTerm) || nisn.includes(searchTerm) || noDaftar.includes(searchTerm);
        
        row.style.display = (jurusanMatch && statusMatch && searchMatch) ? '' : 'none';
    });
}

// Select All Checkbox
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});



// Action Functions
function viewDetail(id) {
    fetch(`/admin/monitoring/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const p = data.data;
                
                // Data Pribadi
                document.getElementById('detailNoDaftar').textContent = p.no_pendaftaran || '-';
                document.getElementById('detailNama').textContent = p.nama || '-';
                document.getElementById('detailNisn').textContent = p.nisn || '-';
                document.getElementById('detailNik').textContent = p.nik || '-';
                document.getElementById('detailJk').textContent = p.jk === 'L' ? 'Laki-laki' : (p.jk === 'P' ? 'Perempuan' : '-');
                document.getElementById('detailTmpLahir').textContent = p.tmp_lahir || '-';
                document.getElementById('detailTglLahir').textContent = p.tgl_lahir || '-';
                document.getElementById('detailAlamat').textContent = p.alamat || '-';
                document.getElementById('detailWilayah').textContent = p.wilayah || '-';
                document.getElementById('detailJurusan').textContent = p.jurusan || '-';
                
                // Status dengan badge
                const statusBadge = {
                    'DRAFT': '<span class="badge bg-secondary">Draft</span>',
                    'SUBMITTED': '<span class="badge bg-warning">Menunggu</span>',
                    'VERIFIED_ADM': '<span class="badge bg-success">Terverifikasi</span>',
                    'REJECTED': '<span class="badge bg-danger">Ditolak</span>'
                };
                document.getElementById('detailStatus').innerHTML = statusBadge[p.status] || '<span class="badge bg-secondary">-</span>';
                document.getElementById('detailTglDaftar').textContent = p.tgl_daftar || '-';
                
                // Data Orang Tua
                document.getElementById('detailNamaAyah').textContent = p.nama_ayah || '-';
                document.getElementById('detailHpAyah').textContent = p.hp_ayah || '-';
                document.getElementById('detailNamaIbu').textContent = p.nama_ibu || '-';
                document.getElementById('detailHpIbu').textContent = p.hp_ibu || '-';
                
                // Asal Sekolah
                document.getElementById('detailAsalSekolah').textContent = p.asal_sekolah || '-';
                document.getElementById('detailNpsn').textContent = p.npsn || '-';
                document.getElementById('detailNilaiRata').textContent = p.nilai_rata || '-';
                
                // Pembayaran
                document.getElementById('detailNominalBayar').textContent = p.nominal_bayar ? 'Rp ' + new Intl.NumberFormat('id-ID').format(p.nominal_bayar) : '-';
                const statusBayar = {
                    'VERIFIED': '<span class="badge bg-success">Terverifikasi</span>',
                    'PENDING': '<span class="badge bg-warning">Menunggu</span>',
                    'REJECTED': '<span class="badge bg-danger">Ditolak</span>',
                    'BELUM_BAYAR': '<span class="badge bg-secondary">Belum Bayar</span>'
                };
                document.getElementById('detailStatusBayar').innerHTML = statusBayar[p.status_bayar] || '<span class="badge bg-secondary">-</span>';
                
                // Update berkas list
                const berkasContainer = document.getElementById('detailBerkas');
                berkasContainer.innerHTML = '';
                
                const berkasTypes = {
                    'IJAZAH': 'Ijazah/SKHUN',
                    'KK': 'Kartu Keluarga', 
                    'AKTA': 'Akta Kelahiran',
                    'KIP': 'Kartu Indonesia Pintar',
                    'LAINNYA': 'Foto & Lainnya'
                };
                
                Object.entries(berkasTypes).forEach(([key, label]) => {
                    const berkas = p.berkas.find(b => b.jenis === key);
                    const status = berkas ? berkas.status : 'BELUM_UPLOAD';
                    const badgeClass = status === 'VERIFIED' ? 'bg-success' : (status === 'PENDING' ? 'bg-warning' : 'bg-danger');
                    const icon = status === 'VERIFIED' ? '✓' : (status === 'PENDING' ? '⏳' : '✗');
                    const fileInfo = berkas ? `(${berkas.nama_file}, ${berkas.ukuran_kb} KB)` : '';
                    
                    berkasContainer.innerHTML += `
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                            <div>
                                <strong>${label}</strong>
                                <br><small class="text-muted">${fileInfo}</small>
                            </div>
                            <span class="badge ${badgeClass}">${icon}</span>
                        </div>
                    `;
                });
                
                new bootstrap.Modal(document.getElementById('detailModal')).show();
            } else {
                alert('Gagal memuat detail pendaftar');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat detail');
        });
}

function downloadBerkas(id) {
    alert('Fitur download berkas akan segera tersedia');
}

function printDetail() {
    window.print();
}
</script>
@endsection