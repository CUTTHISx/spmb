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
                    <h5 class="fw-bold">{{ $stats['total_users'] ?? 0 }}</h5>
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
                    <h5 class="fw-bold">{{ $stats['admin'] ?? 0 }}</h5>
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
                    <h5 class="fw-bold">{{ $stats['keuangan'] ?? 0 }}</h5>
                    <small class="text-muted">Keuangan</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stat-card">
                <div class="card-body text-center py-3">
                    <div class="stat-icon bg-success-light mb-2">
                        <i class="fas fa-calculator text-success fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">{{ $stats['verifikator'] ?? 0 }}</h5>
                    <small class="text-muted">Verifikator</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body text-center py-3">
                    <div class="stat-icon bg-secondary-light mb-2">
                        <i class="fas fa-user-graduate text-secondary fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">{{ $stats['total_pendaftar'] ?? 0 }}</h5>
                    <small class="text-muted">Total Pendaftar</small>
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
                            <th>Tgl Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $user->id }}</span></td>
                            <td class="fw-medium">{{ $user->nama }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                    $roleColors = [
                                        'admin' => 'danger',
                                        'kepsek' => 'warning', 
                                        'keuangan' => 'success',
                                        'verifikator_adm' => 'info',
                                        'pendaftar' => 'secondary'
                                    ];
                                    $color = $roleColors[$user->role] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                            </td>
                            <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <x-action-button variant="info" icon="fas fa-eye" onclick="viewDetail({{ $user->id }})" title="Detail" />
                                    <x-action-button variant="primary" icon="fas fa-edit" onclick="editUser({{ $user->id }})" title="Edit" />
                                    @if($user->id !== auth()->id())
                                    <x-action-button variant="danger" icon="fas fa-trash" onclick="deleteUser({{ $user->id }})" title="Hapus" />
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                <h6>Belum ada data pengguna</h6>
                                <p class="mb-0">Klik tombol "Tambah Akun" untuk menambahkan pengguna baru</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <small class="text-muted">
                        Menampilkan {{ $users->firstItem() }}-{{ $users->lastItem() }} dari {{ $users->total() }} data
                    </small>
                </div>
                <nav>
                    {{ $users->links('pagination::bootstrap-4') }}
                </nav>
            </div>
            @endif
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
    const tglDibuat = row.cells[4].textContent.trim();
    
    // Populate detail modal
    document.getElementById('detailId').textContent = id;
    document.getElementById('detailNama').textContent = nama;
    document.getElementById('detailEmail').textContent = email;
    document.getElementById('detailRole').innerHTML = role;
    document.getElementById('detailStatus').innerHTML = '<span class="badge bg-success">Aktif</span>';
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