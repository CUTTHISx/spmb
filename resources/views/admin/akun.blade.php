@extends('layouts.main')

@section('title', 'Manajemen Akun - PPDB Online')

@section('content')
<div class="container mt-4">
    <div class="card system-status-card">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Manajemen Akun Pengguna</h4>
                    <p class="text-muted mb-0">Kelola akun pengguna sistem PPDB</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahAkunModal">
                    <i class="fas fa-plus me-2"></i>Tambah Akun
                </button>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="form-label">Filter Role</label>
                    <select class="form-select" id="filterRole">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="kepsek">Kepala Sekolah</option>
                        <option value="keuangan">Keuangan</option>
                        <option value="verifikator_adm">Verifikator</option>
                        <option value="pendaftar">Pendaftar</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status Akun</label>
                    <select class="form-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non-Aktif</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cari Pengguna</label>
                    <input type="text" class="form-control" id="searchUser" placeholder="Nama/Email">
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-2">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center py-3">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <h5>{{ $totalUsers ?? 45 }}</h5>
                            <small>Total Akun</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center py-3">
                            <i class="fas fa-user-shield fa-2x mb-2"></i>
                            <h5>{{ $adminCount ?? 3 }}</h5>
                            <small>Admin</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center py-3">
                            <i class="fas fa-user-tie fa-2x mb-2"></i>
                            <h5>{{ $kepsekCount ?? 1 }}</h5>
                            <small>Kepsek</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center py-3">
                            <i class="fas fa-calculator fa-2x mb-2"></i>
                            <h5>{{ $keuanganCount ?? 2 }}</h5>
                            <small>Keuangan</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center py-3">
                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                            <h5>{{ $verifikatorCount ?? 4 }}</h5>
                            <small>Verifikator</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-secondary text-white">
                        <div class="card-body text-center py-3">
                            <i class="fas fa-user-graduate fa-2x mb-2"></i>
                            <h5>{{ $pendaftarCount ?? 35 }}</h5>
                            <small>Pendaftar</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-hover" id="akunTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Login Terakhir</th>
                            <th>Tgl Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users ?? [] as $index => $user)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $user->id ?? $index+1 }}</span></td>
                            <td class="fw-medium">{{ $user->name ?? 'User '.($index+1) }}</td>
                            <td>{{ $user->email ?? 'user'.($index+1).'@ppdb.com' }}</td>
                            <td>
                                @php
                                    $roles = ['admin', 'kepsek', 'keuangan', 'verifikator_adm', 'pendaftar'];
                                    $colors = ['danger', 'warning', 'success', 'info', 'secondary'];
                                    $roleIndex = $index % 5;
                                    $role = $user->role ?? $roles[$roleIndex];
                                    $color = $colors[array_search($role, $roles)] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ ucfirst($role) }}</span>
                            </td>
                            <td>
                                @if(rand(0,1))
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Non-Aktif</span>
                                @endif
                            </td>
                            <td>{{ date('d/m/Y H:i', strtotime('-'.rand(1,72).' hours')) }}</td>
                            <td>{{ date('d/m/Y', strtotime('-'.rand(1,365).' days')) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-primary btn-sm" onclick="editUser({{ $user->id ?? $index+1 }})" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-warning btn-sm" onclick="resetPassword({{ $user->id ?? $index+1 }})" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="deleteUser({{ $user->id ?? $index+1 }})" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        @for($i = 1; $i <= 20; $i++)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $i }}</span></td>
                            <td class="fw-medium">{{ ['Admin System', 'Kepala Sekolah', 'Staff Keuangan', 'Verifikator 1', 'Ahmad Rizki', 'Siti Nurhaliza', 'Budi Santoso'][(($i-1) % 7)] }}</td>
                            <td>{{ ['admin@ppdb.com', 'kepsek@ppdb.com', 'keuangan@ppdb.com', 'verifikator@ppdb.com', 'ahmad@gmail.com', 'siti@gmail.com', 'budi@gmail.com'][(($i-1) % 7)] }}</td>
                            <td>
                                @php
                                    $roles = ['admin', 'kepsek', 'keuangan', 'verifikator_adm', 'pendaftar', 'pendaftar', 'pendaftar'];
                                    $colors = ['danger', 'warning', 'success', 'info', 'secondary', 'secondary', 'secondary'];
                                    $role = $roles[($i-1) % 7];
                                    $color = $colors[($i-1) % 7];
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ ucfirst($role) }}</span>
                            </td>
                            <td>
                                @if($i <= 15)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Non-Aktif</span>
                                @endif
                            </td>
                            <td>{{ date('d/m/Y H:i', strtotime('-'.rand(1,72).' hours')) }}</td>
                            <td>{{ date('d/m/Y', strtotime('-'.rand(1,365).' days')) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-primary btn-sm" onclick="editUser({{ $i }})" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-warning btn-sm" onclick="resetPassword({{ $i }})" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="deleteUser({{ $i }})" title="Hapus">
                                        <i class="fas fa-trash"></i>
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
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <small class="text-muted">Menampilkan 1-20 dari 45 data</small>
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
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

<!-- Tambah Akun Modal -->
<div class="modal fade" id="tambahAkunModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Akun Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="tambahAkunForm">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="kepsek">Kepala Sekolah</option>
                            <option value="keuangan">Keuangan</option>
                            <option value="verifikator_adm">Verifikator</option>
                            <option value="pendaftar">Pendaftar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpanAkun()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Akun Modal -->
<div class="modal fade" id="editAkunModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editAkunForm">
                    <input type="hidden" id="editUserId">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="editName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" id="editRole" required>
                            <option value="admin">Admin</option>
                            <option value="kepsek">Kepala Sekolah</option>
                            <option value="keuangan">Keuangan</option>
                            <option value="verifikator_adm">Verifikator</option>
                            <option value="pendaftar">Pendaftar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="editStatus">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateAkun()">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
// CSRF Token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Filter Functions
document.getElementById('filterRole').addEventListener('change', filterTable);
document.getElementById('filterStatus').addEventListener('change', filterTable);
document.getElementById('searchUser').addEventListener('input', filterTable);

function filterTable() {
    const roleFilter = document.getElementById('filterRole').value;
    const statusFilter = document.getElementById('filterStatus').value;
    const searchTerm = document.getElementById('searchUser').value.toLowerCase();
    
    const rows = document.querySelectorAll('#akunTable tbody tr');
    
    rows.forEach(row => {
        const role = row.cells[3].textContent.toLowerCase();
        const status = row.cells[4].textContent.toLowerCase();
        const name = row.cells[1].textContent.toLowerCase();
        const email = row.cells[2].textContent.toLowerCase();
        
        const roleMatch = !roleFilter || role.includes(roleFilter);
        const statusMatch = !statusFilter || status.includes(statusFilter);
        const searchMatch = !searchTerm || name.includes(searchTerm) || email.includes(searchTerm);
        
        row.style.display = (roleMatch && statusMatch && searchMatch) ? '' : 'none';
    });
}

// Account Management Functions
function simpanAkun() {
    const form = document.getElementById('tambahAkunForm');
    const formData = new FormData(form);
    
    fetch('/admin/akun', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Akun berhasil ditambahkan');
            bootstrap.Modal.getInstance(document.getElementById('tambahAkunModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Gagal menambahkan akun'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menambahkan akun');
    });
}

function editUser(id) {
    // Fetch user data (for now using dummy data)
    document.getElementById('editUserId').value = id;
    document.getElementById('editName').value = 'User ' + id;
    document.getElementById('editEmail').value = 'user' + id + '@ppdb.com';
    document.getElementById('editRole').value = 'pendaftar';
    document.getElementById('editStatus').value = 'aktif';
    
    new bootstrap.Modal(document.getElementById('editAkunModal')).show();
}

function updateAkun() {
    const id = document.getElementById('editUserId').value;
    const formData = {
        name: document.getElementById('editName').value,
        email: document.getElementById('editEmail').value,
        role: document.getElementById('editRole').value,
        status: document.getElementById('editStatus').value
    };
    
    fetch(`/admin/akun/${id}`, {
        method: 'PUT',
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
            alert('Akun berhasil diupdate');
            bootstrap.Modal.getInstance(document.getElementById('editAkunModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Gagal mengupdate akun'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate akun');
    });
}

function resetPassword(id) {
    if(confirm('Reset password untuk user ini? Password akan direset ke "ppdb123"')) {
        fetch(`/admin/akun/${id}/reset-password`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Password berhasil direset. Password baru: ppdb123');
            } else {
                alert('Error: ' + (data.message || 'Gagal reset password'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat reset password');
        });
    }
}

function deleteUser(id) {
    if(confirm('Hapus akun ini? Tindakan ini tidak dapat dibatalkan.')) {
        fetch(`/admin/akun/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Akun berhasil dihapus');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Gagal menghapus akun'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus akun');
        });
    }
}
</script>
@endsection