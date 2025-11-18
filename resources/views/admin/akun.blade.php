@extends('layouts.main')

@section('title', 'Manajemen Akun - PPDB Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/layouts/dashboard.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <!-- Stats Overview -->
    <div class="row g-4 mb-4">
        <div class="col-md-2">
            <div class="card stat-card">
                <div class="card-body text-center py-3">
                    <div class="stat-icon bg-primary-light mb-2">
                        <i class="fas fa-users text-primary fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">{{ $totalUsers ?? 45 }}</h5>
                    <small class="text-muted">Total Akun</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stat-card">
                <div class="card-body text-center py-3">
                    <div class="stat-icon bg-danger-light mb-2">
                        <i class="fas fa-user-shield text-danger fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">{{ $adminCount ?? 3 }}</h5>
                    <small class="text-muted">Admin</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stat-card">
                <div class="card-body text-center py-3">
                    <div class="stat-icon bg-warning-light mb-2">
                        <i class="fas fa-user-tie text-warning fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">{{ $kepsekCount ?? 1 }}</h5>
                    <small class="text-muted">Kepsek</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stat-card">
                <div class="card-body text-center py-3">
                    <div class="stat-icon bg-success-light mb-2">
                        <i class="fas fa-calculator text-success fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">{{ $keuanganCount ?? 2 }}</h5>
                    <small class="text-muted">Keuangan</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stat-card">
                <div class="card-body text-center py-3">
                    <div class="stat-icon bg-info-light mb-2">
                        <i class="fas fa-check-circle text-info fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">{{ $verifikatorCount ?? 4 }}</h5>
                    <small class="text-muted">Verifikator</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stat-card">
                <div class="card-body text-center py-3">
                    <div class="stat-icon bg-secondary-light mb-2">
                        <i class="fas fa-user-graduate text-secondary fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">{{ $pendaftarCount ?? 35 }}</h5>
                    <small class="text-muted">Pendaftar</small>
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
                        <i class="fas fa-users-cog text-primary me-2"></i>
                        Manajemen Akun Pengguna
                    </h5>
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
                <div class="col-md-4">
                    <label class="form-label fw-medium">Filter Role</label>
                    <select class="form-select" id="filterRole">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="kepsek">Kepala Sekolah</option>
                        <option value="keuangan">Keuangan</option>
                        <option value="verifikator_adm">Verifikator</option>
                        <option value="pendaftar">Pendaftar</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Cari Pengguna</label>
                    <input type="text" class="form-control" id="searchUser" placeholder="Nama/Email">
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
                            <th>Login Terakhir</th>
                            <th>Tgl Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users ?? [] as $index => $user)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $user->id ?? $index+1 }}</span></td>
                            <td class="fw-medium">{{ $user->nama ?? 'User '.($index+1) }}</td>
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

                            <td>{{ date('d/m/Y H:i', strtotime('-'.rand(1,72).' hours')) }}</td>
                            <td>{{ date('d/m/Y', strtotime('-'.rand(1,365).' days')) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-info btn-sm" onclick="viewDetail({{ $user->id ?? $index+1 }})" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm" onclick="editUser({{ $user->id ?? $index+1 }})" title="Edit">
                                        <i class="fas fa-edit"></i>
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

                            <td>{{ date('d/m/Y H:i', strtotime('-'.rand(1,72).' hours')) }}</td>
                            <td>{{ date('d/m/Y', strtotime('-'.rand(1,365).' days')) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-info btn-sm" onclick="viewDetail({{ $i }})" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm" onclick="editUser({{ $i }})" title="Edit">
                                        <i class="fas fa-edit"></i>
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

<!-- Detail Akun Modal -->
<div class="modal fade" id="detailAkunModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Akun Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Informasi Akun</h6>
                        <table class="table table-sm">
                            <tr><td class="fw-medium">ID</td><td id="detailId">-</td></tr>
                            <tr><td class="fw-medium">Nama Lengkap</td><td id="detailNama">-</td></tr>
                            <tr><td class="fw-medium">Email</td><td id="detailEmail">-</td></tr>
                            <tr><td class="fw-medium">Role</td><td id="detailRole">-</td></tr>
                            <tr><td class="fw-medium">Status</td><td id="detailStatus">-</td></tr>
                            <tr><td class="fw-medium">Login Terakhir</td><td id="detailLoginTerakhir">-</td></tr>
                            <tr><td class="fw-medium">Tanggal Dibuat</td><td id="detailTglDibuat">-</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Ganti Password</h6>
                        <form id="changePasswordForm">
                            <input type="hidden" id="passwordUserId">
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="newPassword" minlength="6">
                                <div class="form-text">Minimal 6 karakter</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="confirmPassword">
                            </div>
                            <button type="button" class="btn btn-warning" onclick="updatePassword()">
                                <i class="fas fa-key me-2"></i>Ganti Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
// CSRF Token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Filter Functions
document.getElementById('filterRole').addEventListener('change', filterTable);
document.getElementById('searchUser').addEventListener('input', filterTable);

function filterTable() {
    const roleFilter = document.getElementById('filterRole').value;
    const searchTerm = document.getElementById('searchUser').value.toLowerCase();
    
    const rows = document.querySelectorAll('#akunTable tbody tr');
    
    rows.forEach(row => {
        const role = row.cells[3].textContent.toLowerCase();
        const name = row.cells[1].textContent.toLowerCase();
        const email = row.cells[2].textContent.toLowerCase();
        
        const roleMatch = !roleFilter || role.includes(roleFilter);
        const searchMatch = !searchTerm || name.includes(searchTerm) || email.includes(searchTerm);
        
        row.style.display = (roleMatch && searchMatch) ? '' : 'none';
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
    // Get user data from table row
    const row = document.querySelector(`button[onclick="editUser(${id})"]`).closest('tr');
    const nama = row.cells[1].textContent.trim();
    const email = row.cells[2].textContent.trim();
    const role = row.cells[3].textContent.toLowerCase().trim();
    
    document.getElementById('editUserId').value = id;
    document.getElementById('editName').value = nama;
    document.getElementById('editEmail').value = email;
    document.getElementById('editRole').value = role === 'kepala sekolah' ? 'kepsek' : role;
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



function viewDetail(id) {
    // Get user data from table row
    const row = document.querySelector(`button[onclick="viewDetail(${id})"]`).closest('tr');
    const nama = row.cells[1].textContent.trim();
    const email = row.cells[2].textContent.trim();
    const role = row.cells[3].textContent.trim();
    const loginTerakhir = row.cells[4].textContent.trim();
    const tglDibuat = row.cells[5].textContent.trim();
    
    // Populate detail modal
    document.getElementById('detailId').textContent = id;
    document.getElementById('detailNama').textContent = nama;
    document.getElementById('detailEmail').textContent = email;
    document.getElementById('detailRole').innerHTML = role;
    document.getElementById('detailStatus').innerHTML = '<span class="badge bg-success">Aktif</span>';
    document.getElementById('detailLoginTerakhir').textContent = loginTerakhir;
    document.getElementById('detailTglDibuat').textContent = tglDibuat;
    
    // Set up password change form
    document.getElementById('passwordUserId').value = id;
    document.getElementById('newPassword').value = '';
    document.getElementById('confirmPassword').value = '';
    
    new bootstrap.Modal(document.getElementById('detailAkunModal')).show();
}

function updatePassword() {
    const id = document.getElementById('passwordUserId').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (!newPassword || !confirmPassword) {
        alert('Mohon isi password baru dan konfirmasi password');
        return;
    }
    
    if (newPassword.length < 6) {
        alert('Password minimal 6 karakter');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        alert('Konfirmasi password tidak cocok');
        return;
    }
    
    const formData = {
        password: newPassword
    };
    
    fetch(`/admin/akun/${id}/password`, {
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
            alert('Password berhasil diubah');
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
        } else {
            alert('Error: ' + (data.message || 'Gagal mengubah password'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengubah password');
    });
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