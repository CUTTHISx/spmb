@extends('layouts.main')

@section('title', 'Audit Log - PPDB Online')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Audit Log Sistem</h5>
                </div>
                <div class="card-body">
                    <!-- Filter Controls -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <select class="form-select" id="filterUser">
                                <option value="">Semua User</option>
                                <option value="admin">Admin</option>
                                <option value="verifikator">Verifikator</option>
                                <option value="keuangan">Keuangan</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="filterAction">
                                <option value="">Semua Aksi</option>
                                <option value="login">Login</option>
                                <option value="create">Create</option>
                                <option value="update">Update</option>
                                <option value="delete">Delete</option>
                                <option value="verify">Verify</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="filterDate">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Cari..." id="searchInput">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary me-2" onclick="filterLogs()">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                            <button class="btn btn-success" onclick="exportLogs()">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                        </div>
                    </div>

                    <!-- Audit Log Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Waktu</th>
                                    <th>User</th>
                                    <th>Aksi</th>
                                    <th>Target</th>
                                    <th>Detail</th>
                                    <th>IP Address</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="auditTableBody">
                                <tr>
                                    <td>2024-11-13 14:30:25</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle p-1 me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-user text-white small"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">admin@ppdb.com</div>
                                                <small class="text-muted">Admin</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-info">UPDATE</span></td>
                                    <td>Pendaftar #PPDB-2024-001</td>
                                    <td>Mengubah status verifikasi menjadi "Lulus"</td>
                                    <td>192.168.1.100</td>
                                    <td><span class="badge bg-success">Success</span></td>
                                </tr>
                                <tr>
                                    <td>2024-11-13 14:25:10</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success rounded-circle p-1 me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-user text-white small"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">verifikator@ppdb.com</div>
                                                <small class="text-muted">Verifikator</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-warning">VERIFY</span></td>
                                    <td>Berkas Pendaftar #PPDB-2024-002</td>
                                    <td>Memverifikasi kelengkapan berkas administrasi</td>
                                    <td>192.168.1.105</td>
                                    <td><span class="badge bg-success">Success</span></td>
                                </tr>
                                <tr>
                                    <td>2024-11-13 14:20:45</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning rounded-circle p-1 me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-user text-white small"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">keuangan@ppdb.com</div>
                                                <small class="text-muted">Keuangan</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success">VERIFY</span></td>
                                    <td>Pembayaran #PAY-2024-001</td>
                                    <td>Memverifikasi bukti pembayaran sebesar Rp 250.000</td>
                                    <td>192.168.1.110</td>
                                    <td><span class="badge bg-success">Success</span></td>
                                </tr>
                                <tr>
                                    <td>2024-11-13 14:15:30</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle p-1 me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-user text-white small"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">admin@ppdb.com</div>
                                                <small class="text-muted">Admin</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-primary">CREATE</span></td>
                                    <td>Master Data Jurusan</td>
                                    <td>Menambahkan jurusan baru: Multimedia</td>
                                    <td>192.168.1.100</td>
                                    <td><span class="badge bg-success">Success</span></td>
                                </tr>
                                <tr>
                                    <td>2024-11-13 14:10:15</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger rounded-circle p-1 me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-user text-white small"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">unknown@user.com</div>
                                                <small class="text-muted">Unknown</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-secondary">LOGIN</span></td>
                                    <td>System Login</td>
                                    <td>Percobaan login dengan kredensial salah</td>
                                    <td>192.168.1.200</td>
                                    <td><span class="badge bg-danger">Failed</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>
                            <li class="page-item active">
                                <span class="page-link">1</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function filterLogs() {
    // Implement filter functionality
    console.log('Filtering logs...');
}

function exportLogs() {
    // Implement export functionality
    alert('Export logs functionality will be implemented');
}
</script>
@endsection