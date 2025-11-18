@extends('layouts.main')

@section('title', 'Kelola Pengumuman - PPDB Online')

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
                                <i class="fas fa-bullhorn fa-2x"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">Kelola Pengumuman</h2>
                            <p class="mb-0 opacity-90">Atur tanggal dan waktu pengumuman hasil seleksi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center py-3">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <h4>{{ $lulus }}</h4>
                    <small>Lulus Seleksi</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center py-3">
                    <i class="fas fa-times-circle fa-2x mb-2"></i>
                    <h4>{{ $tidakLulus }}</h4>
                    <small>Tidak Lulus</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center py-3">
                    <i class="fas fa-hourglass-half fa-2x mb-2"></i>
                    <h4>{{ $menunggu }}</h4>
                    <small>Menunggu Verifikasi</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center py-3">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <h4>{{ $lulus + $tidakLulus + $menunggu }}</h4>
                    <small>Total Pendaftar</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengumuman Settings -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-cog text-primary me-2"></i>
                        Pengaturan Pengumuman
                    </h5>
                </div>
                <div class="card-body">
                    <form id="pengumumanForm">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Pengumuman</label>
                                <input type="date" class="form-control" id="tanggalPengumuman" 
                                       value="{{ $pengumuman->tanggal_pengumuman ?? '' }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jam Pengumuman</label>
                                <input type="time" class="form-control" id="jamPengumuman" 
                                       value="{{ $pengumuman->jam_pengumuman ?? '10:00' }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status Pengumuman</label>
                                <select class="form-select" id="statusPengumuman" required>
                                    <option value="NONAKTIF" {{ ($pengumuman->status ?? '') == 'NONAKTIF' ? 'selected' : '' }}>Nonaktif</option>
                                    <option value="AKTIF" {{ ($pengumuman->status ?? '') == 'AKTIF' ? 'selected' : '' }}>Aktif</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Simpan Pengaturan
                            </button>
                            @if($pengumuman && $pengumuman->status == 'AKTIF')
                            <span class="badge bg-success ms-2">
                                <i class="fas fa-broadcast-tower me-1"></i>Pengumuman Aktif
                            </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('pengumumanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        tanggal_pengumuman: document.getElementById('tanggalPengumuman').value,
        jam_pengumuman: document.getElementById('jamPengumuman').value,
        status: document.getElementById('statusPengumuman').value
    };
    
    fetch('/admin/pengumuman', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
    })
    
    Claude
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Pengaturan pengumuman berhasil disimpan!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan saat menyimpan pengaturan.');
    });
});
</script>
@endsection