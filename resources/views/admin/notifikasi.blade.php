@extends('layouts.main')

@section('title', 'Kelola Notifikasi - PPDB Online')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Kelola Notifikasi</h5>
                </div>
                <div class="card-body">
                    <!-- Notification Stats -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h4>1,234</h4>
                                    <small>Email Terkirim</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h4>856</h4>
                                    <small>WhatsApp Terkirim</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h4>45</h4>
                                    <small>Pending</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h4>12</h4>
                                    <small>Gagal</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Send Notification Form -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Kirim Notifikasi Baru</h6>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tipe Notifikasi</label>
                                                    <select class="form-select" id="notificationType">
                                                        <option value="email">Email</option>
                                                        <option value="whatsapp">WhatsApp</option>
                                                        <option value="sms">SMS</option>
                                                        <option value="all">Semua Channel</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Target Penerima</label>
                                                    <select class="form-select" id="targetRecipient">
                                                        <option value="all">Semua Pendaftar</option>
                                                        <option value="verified">Pendaftar Terverifikasi</option>
                                                        <option value="pending">Menunggu Verifikasi</option>
                                                        <option value="paid">Sudah Bayar</option>
                                                        <option value="unpaid">Belum Bayar</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Subjek</label>
                                            <input type="text" class="form-control" placeholder="Masukkan subjek notifikasi">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pesan</label>
                                            <textarea class="form-control" rows="4" placeholder="Masukkan isi pesan..."></textarea>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-primary">
                                                <i class="fas fa-paper-plane me-1"></i>Kirim Sekarang
                                            </button>
                                            <button type="button" class="btn btn-outline-primary">
                                                <i class="fas fa-clock me-1"></i>Jadwalkan
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary">
                                                <i class="fas fa-eye me-1"></i>Preview
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notification History -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Riwayat Notifikasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Waktu</th>
                                            <th>Tipe</th>
                                            <th>Subjek</th>
                                            <th>Penerima</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>13 Nov 2024, 14:30</td>
                                            <td><span class="badge bg-primary">Email</span></td>
                                            <td>Pengumuman Hasil Verifikasi</td>
                                            <td>25 pendaftar</td>
                                            <td><span class="badge bg-success">Terkirim</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>13 Nov 2024, 12:15</td>
                                            <td><span class="badge bg-success">WhatsApp</span></td>
                                            <td>Reminder Pembayaran</td>
                                            <td>15 pendaftar</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>12 Nov 2024, 16:45</td>
                                            <td><span class="badge bg-info">SMS</span></td>
                                            <td>Kode OTP Login</td>
                                            <td>1 pendaftar</td>
                                            <td><span class="badge bg-success">Terkirim</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection