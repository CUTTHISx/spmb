@extends('layouts.main')

@section('title', 'Monitoring Berkas - PPDB Online')

@section('content')
<div class="container mt-4">
    <div class="card system-status-card">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Monitoring Berkas Pendaftar</h4>
                    <p class="text-muted mb-0">Kelola dan verifikasi kelengkapan berkas pendaftar</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-success" onclick="exportData('excel')">
                        <i class="fas fa-file-excel me-2"></i>Export Excel
                    </button>
                    <button class="btn btn-danger" onclick="exportData('pdf')">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="form-label">Filter Jurusan</label>
                    <select class="form-select" id="filterJurusan">
                        <option value="">Semua Jurusan</option>
                        <option value="TI">Teknik Informatika</option>
                        <option value="SI">Sistem Informasi</option>
                        <option value="TKJ">Teknik Komputer Jaringan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status Berkas</label>
                    <select class="form-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="lengkap">Lengkap</option>
                        <option value="tidak_lengkap">Tidak Lengkap</option>
                        <option value="menunggu">Menunggu Verifikasi</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Gelombang</label>
                    <select class="form-select" id="filterGelombang">
                        <option value="">Semua Gelombang</option>
                        <option value="1">Gelombang 1</option>
                        <option value="2">Gelombang 2</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Cari Pendaftar</label>
                    <input type="text" class="form-control" id="searchPendaftar" placeholder="Nama/NISN/No. Daftar">
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <h4>{{ $totalPendaftar ?? 156 }}</h4>
                            <small>Total Pendaftar</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                            <h4>{{ $berkasLengkap ?? 89 }}</h4>
                            <small>Berkas Lengkap</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-clock fa-2x mb-2"></i>
                            <h4>{{ $menungguVerifikasi ?? 34 }}</h4>
                            <small>Menunggu Verifikasi</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <h4>{{ $berkasKurang ?? 33 }}</h4>
                            <small>Berkas Kurang</small>
                        </div>
                    </div>
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
                                    @if($p->status == 'SUBMITTED')
                                        <button class="btn btn-outline-success btn-sm" onclick="verifikasi({{ $p->id }})" title="Verifikasi">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    <button class="btn btn-outline-info btn-sm" onclick="downloadBerkas({{ $p->id }})" title="Download Berkas">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        @for($i = 1; $i <= 15; $i++)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input row-checkbox" value="{{ $i }}">
                            </td>
                            <td>
                                <span class="badge bg-primary">PPDB{{ date('Y') }}{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="fw-medium">{{ ['Ahmad Rizki', 'Siti Nurhaliza', 'Budi Santoso', 'Dewi Sartika', 'Andi Wijaya'][($i-1) % 5] }}</td>
                            <td>{{ '123456789' . $i }}</td>
                            <td>
                                <span class="badge bg-info">{{ ['Teknik Informatika', 'Sistem Informasi', 'TKJ'][($i-1) % 3] }}</span>
                            </td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    @php
                                        $progress = [100, 83, 67, 50, 100, 83, 100, 67, 100, 50, 83, 100, 67, 83, 100][$i-1];
                                        $color = $progress == 100 ? 'success' : ($progress >= 70 ? 'warning' : 'danger');
                                    @endphp
                                    <div class="progress-bar bg-{{ $color }}" style="width: {{ $progress }}%">
                                        {{ $progress }}%
                                    </div>
                                </div>
                                <small class="text-muted">{{ (int)($progress/100*6) }}/6 berkas</small>
                            </td>
                            <td>
                                @if($progress == 100)
                                    <span class="badge bg-success">Lengkap</span>
                                @elseif($progress >= 70)
                                    <span class="badge bg-warning">Menunggu</span>
                                @else
                                    <span class="badge bg-danger">Kurang</span>
                                @endif
                            </td>
                            <td>{{ date('d/m/Y', strtotime('-'.rand(1,30).' days')) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-primary btn-sm" onclick="viewDetail({{ $i }})" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-success btn-sm" onclick="verifikasi({{ $i }})" title="Verifikasi">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-outline-info btn-sm" onclick="downloadBerkas({{ $i }})" title="Download Berkas">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endfor
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Berkas Pendaftar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Data Pendaftar</h6>
                        <table class="table table-sm">
                            <tr><td>No. Daftar</td><td id="detailNoDaftar">-</td></tr>
                            <tr><td>Nama</td><td id="detailNama">-</td></tr>
                            <tr><td>NISN</td><td id="detailNisn">-</td></tr>
                            <tr><td>Jurusan</td><td id="detailJurusan">-</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Kelengkapan Berkas</h6>
                        <div id="detailBerkas">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Ijazah/SKHUN</span>
                                <span class="badge bg-success">✓</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Kartu Keluarga</span>
                                <span class="badge bg-success">✓</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Akta Kelahiran</span>
                                <span class="badge bg-danger">✗</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success">Verifikasi Berkas</button>
            </div>
        </div>
    </div>
</div>

<script>
// Filter and Search Functions
document.getElementById('filterJurusan').addEventListener('change', filterTable);
document.getElementById('filterStatus').addEventListener('change', filterTable);
document.getElementById('filterGelombang').addEventListener('change', filterTable);
document.getElementById('searchPendaftar').addEventListener('input', filterTable);

function filterTable() {
    // Implementation for filtering table
    console.log('Filtering table...');
}

// Select All Checkbox
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

// Export Functions
function exportData(type) {
    alert(`Exporting data as ${type.toUpperCase()}...`);
}

// Action Functions
function viewDetail(id) {
    document.getElementById('detailNoDaftar').textContent = 'PPDB2024' + String(id).padStart(4, '0');
    document.getElementById('detailNama').textContent = 'Ahmad Rizki Pratama';
    document.getElementById('detailNisn').textContent = '1234567890';
    document.getElementById('detailJurusan').textContent = 'Teknik Informatika';
    
    new bootstrap.Modal(document.getElementById('detailModal')).show();
}

function verifikasi(id) {
    if(confirm('Verifikasi berkas pendaftar ini?')) {
        alert('Berkas berhasil diverifikasi');
    }
}

function downloadBerkas(id) {
    alert('Downloading berkas pendaftar...');
}
</script>
@endsection