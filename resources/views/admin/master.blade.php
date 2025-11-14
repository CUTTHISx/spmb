@extends('layouts.main')

@section('title', 'Master Data - PPDB Online')

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
                                <i class="fas fa-database fa-2x"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">Master Data PPDB</h2>
                            <p class="mb-0 opacity-90">Kelola data master sistem penerimaan peserta didik baru</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <ul class="nav nav-tabs card-header-tabs" id="masterDataTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="jurusan-tab" data-bs-toggle="tab" data-bs-target="#jurusan" type="button" role="tab">
                        <i class="fas fa-graduation-cap me-2"></i>Jurusan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="gelombang-tab" data-bs-toggle="tab" data-bs-target="#gelombang" type="button" role="tab">
                        <i class="fas fa-calendar-alt me-2"></i>Gelombang
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="wilayah-tab" data-bs-toggle="tab" data-bs-target="#wilayah" type="button" role="tab">
                        <i class="fas fa-map-marker-alt me-2"></i>Wilayah
                    </button>
                </li>
            </ul>
        </div>
        
        <div class="card-body">
            <div class="tab-content" id="masterDataTabsContent">
                <!-- Jurusan Tab -->
                <div class="tab-pane fade show active" id="jurusan" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="mb-1 fw-bold">Data Jurusan & Kuota</h5>
                            <p class="text-muted mb-0">Kelola jurusan yang tersedia dan kuota penerimaan</p>
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jurusanModal" onclick="resetJurusanForm()">
                            <i class="fas fa-plus me-2"></i>Tambah Jurusan
                        </button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Jurusan</th>
                                    <th>Kuota</th>
                                    <th>Terisi</th>
                                    <th>Sisa</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jurusan ?? [] as $j)
                                @php
                                    $terisi = $j->pendaftar()->where('status', '!=', 'DRAFT')->count();
                                    $sisa = $j->kuota - $terisi;
                                @endphp
                                <tr>
                                    <td><span class="badge bg-primary">{{ $j->kode }}</span></td>
                                    <td class="fw-medium">{{ $j->nama }}</td>
                                    <td><span class="badge bg-info">{{ $j->kuota }}</span></td>
                                    <td><span class="badge bg-success">{{ $terisi }}</span></td>
                                    <td><span class="badge bg-{{ $sisa > 10 ? 'warning' : 'danger' }}">{{ $sisa }}</span></td>
                                    <td>
                                        @if($sisa > 0)
                                            <span class="badge bg-success">Tersedia</span>
                                        @else
                                            <span class="badge bg-danger">Penuh</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-outline-primary btn-sm" onclick="editJurusan({{ $j->id }}, '{{ $j->kode }}', '{{ $j->nama }}', {{ $j->kuota }})" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="deleteJurusan({{ $j->id }})" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-folder-open fa-2x mb-2"></i>
                                        <p>Belum ada data jurusan</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Gelombang Tab -->
                <div class="tab-pane fade" id="gelombang" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="mb-1 fw-bold">Gelombang Pendaftaran</h5>
                            <p class="text-muted mb-0">Atur periode waktu pendaftaran</p>
                        </div>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#gelombangModal" onclick="resetGelombangForm()">
                            <i class="fas fa-plus me-2"></i>Tambah Gelombang
                        </button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Gelombang</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Biaya Daftar</th>
                                    <th>Status</th>
                                    <th>Pendaftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($gelombang ?? [] as $g)
                                @php
                                    $now = now();
                                    $mulai = \Carbon\Carbon::parse($g->tgl_mulai);
                                    $selesai = \Carbon\Carbon::parse($g->tgl_selesai);
                                    $durasi = $mulai->diffInDays($selesai);
                                    $pendaftar = $g->pendaftar()->count();
                                @endphp
                                <tr>
                                    <td class="fw-medium">{{ $g->nama }}</td>
                                    <td>{{ $mulai->format('d M Y') }}</td>
                                    <td>{{ $selesai->format('d M Y') }}</td>
                                    <td><span class="badge bg-success">Rp {{ number_format($g->biaya_daftar, 0, ',', '.') }}</span></td>
                                    <td>
                                        @if($g->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-primary">{{ $pendaftar }}</span></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-outline-primary btn-sm" onclick="editGelombang({{ $g->id }}, '{{ $g->nama }}', '{{ $g->tgl_mulai }}', '{{ $g->tgl_selesai }}', {{ $g->biaya_daftar }}, '{{ $g->status }}')" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="deleteGelombang({{ $g->id }})" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                        <p>Belum ada gelombang pendaftaran</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Wilayah Tab -->
                <div class="tab-pane fade" id="wilayah" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="mb-1 fw-bold">Data Wilayah</h5>
                            <p class="text-muted mb-0">Kelola data provinsi, kabupaten, kecamatan, dan kelurahan</p>
                        </div>
                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#wilayahModal" onclick="resetWilayahForm()">
                            <i class="fas fa-plus me-2"></i>Tambah Wilayah
                        </button>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="searchWilayah" placeholder="Cari wilayah...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterProvinsi">
                                <option value="">Semua Provinsi</option>
                                @foreach($wilayah ?? [] as $w)
                                    <option value="{{ $w->provinsi }}">{{ $w->provinsi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover" id="wilayahTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Pos</th>
                                    <th>Kelurahan</th>
                                    <th>Kecamatan</th>
                                    <th>Kabupaten</th>
                                    <th>Provinsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($wilayah ?? [] as $w)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $w->kodepos }}</span></td>
                                    <td>{{ $w->kelurahan }}</td>
                                    <td>{{ $w->kecamatan }}</td>
                                    <td>{{ $w->kabupaten }}</td>
                                    <td>{{ $w->provinsi }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-outline-primary btn-sm" onclick="editWilayah({{ $w->id }}, '{{ $w->provinsi }}', '{{ $w->kabupaten }}', '{{ $w->kecamatan }}', '{{ $w->kelurahan }}', '{{ $w->kodepos }}')" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="deleteWilayah({{ $w->id }})" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-map fa-2x mb-2"></i>
                                        <p>Belum ada data wilayah</p>
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

<!-- Modal Jurusan -->
<div class="modal fade" id="jurusanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jurusanModalTitle">Tambah Jurusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="jurusanForm">
                <div class="modal-body">
                    <input type="hidden" id="jurusanId">
                    <div class="mb-3">
                        <label class="form-label">Kode Jurusan</label>
                        <input type="text" class="form-control" id="jurusanKode" required>
                        <div class="form-text">Contoh: TI01, AK01, AP01</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Jurusan</label>
                        <input type="text" class="form-control" id="jurusanNama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kuota</label>
                        <input type="number" class="form-control" id="jurusanKuota" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Gelombang -->
<div class="modal fade" id="gelombangModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gelombangModalTitle">Tambah Gelombang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="gelombangForm">
                <div class="modal-body">
                    <input type="hidden" id="gelombangId">
                    <div class="mb-3">
                        <label class="form-label">Nama Gelombang</label>
                        <input type="text" class="form-control" id="gelombangNama" required>
                        <div class="form-text">Contoh: Gelombang 1, Gelombang 2</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="gelombangMulai" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="gelombangSelesai" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya Pendaftaran</label>
                        <input type="number" class="form-control" id="gelombangBiaya" min="0" required>
                        <div class="form-text">Masukkan biaya dalam rupiah</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="gelombangStatus" required>
                            <option value="aktif">Aktif</option>
                            <option value="non-aktif">Non-Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Wilayah -->
<div class="modal fade" id="wilayahModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wilayahModalTitle">Tambah Wilayah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="wilayahForm">
                <div class="modal-body">
                    <input type="hidden" id="wilayahId">
                    <div class="mb-3">
                        <label class="form-label">Provinsi</label>
                        <input type="text" class="form-control" id="wilayahProvinsi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kabupaten/Kota</label>
                        <input type="text" class="form-control" id="wilayahKabupaten" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" class="form-control" id="wilayahKecamatan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelurahan</label>
                        <input type="text" class="form-control" id="wilayahKelurahan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Pos</label>
                        <input type="text" class="form-control" id="wilayahKodepos" maxlength="5" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Jurusan Functions
function resetJurusanForm() {
    document.getElementById('jurusanForm').reset();
    document.getElementById('jurusanId').value = '';
    document.getElementById('jurusanModalTitle').textContent = 'Tambah Jurusan';
}

function editJurusan(id, kode, nama, kuota) {
    document.getElementById('jurusanId').value = id;
    document.getElementById('jurusanKode').value = kode;
    document.getElementById('jurusanNama').value = nama;
    document.getElementById('jurusanKuota').value = kuota;
    document.getElementById('jurusanModalTitle').textContent = 'Edit Jurusan';
    new bootstrap.Modal(document.getElementById('jurusanModal')).show();
}

function deleteJurusan(id) {
    if(confirm('Hapus jurusan ini? Data yang terkait akan ikut terhapus.')) {
        fetch(`/admin/jurusan/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Jurusan berhasil dihapus');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Gagal menghapus jurusan'));
            }
        });
    }
}

document.getElementById('jurusanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('jurusanId').value;
    const formData = {
        kode: document.getElementById('jurusanKode').value,
        nama: document.getElementById('jurusanNama').value,
        kuota: document.getElementById('jurusanKuota').value
    };
    
    const url = id ? `/admin/jurusan/${id}` : '/admin/jurusan';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(id ? 'Jurusan berhasil diupdate' : 'Jurusan berhasil ditambahkan');
            bootstrap.Modal.getInstance(document.getElementById('jurusanModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Gagal menyimpan jurusan'));
        }
    });
});

// Gelombang Functions
function resetGelombangForm() {
    document.getElementById('gelombangForm').reset();
    document.getElementById('gelombangId').value = '';
    document.getElementById('gelombangBiaya').value = 250000;
    document.getElementById('gelombangStatus').value = 'aktif';
    document.getElementById('gelombangModalTitle').textContent = 'Tambah Gelombang';
}

function editGelombang(id, nama, mulai, selesai, biaya, status) {
    document.getElementById('gelombangId').value = id;
    document.getElementById('gelombangNama').value = nama;
    document.getElementById('gelombangMulai').value = mulai;
    document.getElementById('gelombangSelesai').value = selesai;
    document.getElementById('gelombangBiaya').value = biaya;
    document.getElementById('gelombangStatus').value = status;
    document.getElementById('gelombangModalTitle').textContent = 'Edit Gelombang';
    new bootstrap.Modal(document.getElementById('gelombangModal')).show();
}

function deleteGelombang(id) {
    if(confirm('Hapus gelombang ini? Data pendaftar yang terkait akan ikut terhapus.')) {
        fetch(`/admin/gelombang/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Gelombang berhasil dihapus');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Gagal menghapus gelombang'));
            }
        });
    }
}

document.getElementById('gelombangForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('gelombangId').value;
    const formData = {
        nama: document.getElementById('gelombangNama').value,
        tgl_mulai: document.getElementById('gelombangMulai').value,
        tgl_selesai: document.getElementById('gelombangSelesai').value,
        biaya_daftar: document.getElementById('gelombangBiaya').value,
        status: document.getElementById('gelombangStatus').value
    };
    
    const url = id ? `/admin/gelombang/${id}` : '/admin/gelombang';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(id ? 'Gelombang berhasil diupdate' : 'Gelombang berhasil ditambahkan');
            bootstrap.Modal.getInstance(document.getElementById('gelombangModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Gagal menyimpan gelombang'));
        }
    });
});

// Wilayah Functions
function resetWilayahForm() {
    document.getElementById('wilayahForm').reset();
    document.getElementById('wilayahId').value = '';
    document.getElementById('wilayahModalTitle').textContent = 'Tambah Wilayah';
}

function editWilayah(id, provinsi, kabupaten, kecamatan, kelurahan, kodepos) {
    document.getElementById('wilayahId').value = id;
    document.getElementById('wilayahProvinsi').value = provinsi;
    document.getElementById('wilayahKabupaten').value = kabupaten;
    document.getElementById('wilayahKecamatan').value = kecamatan;
    document.getElementById('wilayahKelurahan').value = kelurahan;
    document.getElementById('wilayahKodepos').value = kodepos;
    document.getElementById('wilayahModalTitle').textContent = 'Edit Wilayah';
    new bootstrap.Modal(document.getElementById('wilayahModal')).show();
}

function deleteWilayah(id) {
    if(confirm('Hapus data wilayah ini?')) {
        fetch(`/admin/wilayah/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Wilayah berhasil dihapus');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Gagal menghapus wilayah'));
            }
        });
    }
}

document.getElementById('wilayahForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('wilayahId').value;
    const formData = {
        provinsi: document.getElementById('wilayahProvinsi').value,
        kabupaten: document.getElementById('wilayahKabupaten').value,
        kecamatan: document.getElementById('wilayahKecamatan').value,
        kelurahan: document.getElementById('wilayahKelurahan').value,
        kodepos: document.getElementById('wilayahKodepos').value
    };
    
    const url = id ? `/admin/wilayah/${id}` : '/admin/wilayah';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(id ? 'Wilayah berhasil diupdate' : 'Wilayah berhasil ditambahkan');
            bootstrap.Modal.getInstance(document.getElementById('wilayahModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Gagal menyimpan wilayah'));
        }
    });
});

// Search and Filter
document.getElementById('searchWilayah').addEventListener('input', filterWilayah);
document.getElementById('filterProvinsi').addEventListener('change', filterWilayah);

function filterWilayah() {
    const search = document.getElementById('searchWilayah').value.toLowerCase();
    const provinsi = document.getElementById('filterProvinsi').value;
    const rows = document.querySelectorAll('#wilayahTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const provinsiCell = row.cells[4]?.textContent || '';
        
        const searchMatch = !search || text.includes(search);
        const provinsiMatch = !provinsi || provinsiCell === provinsi;
        
        row.style.display = (searchMatch && provinsiMatch) ? '' : 'none';
    });
}
</script>
@endsection