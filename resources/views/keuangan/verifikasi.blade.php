@extends('layouts.main')

@section('title', 'Verifikasi Pembayaran - PPDB Online')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-money-bill me-2"></i>Verifikasi Pembayaran</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No. Daftar</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Status Bayar</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftar as $p)
                        <tr>
                            <td>{{ $p->no_pendaftaran ?? 'Belum Ada' }}</td>
                            <td>{{ $p->user->name }}</td>
                            <td>{{ $p->jurusan->nama ?? 'Belum Pilih' }}</td>
                            <td>
                                <span class="badge bg-{{ $p->status_payment == 'VERIFIED' ? 'success' : ($p->status_payment == 'REJECTED' ? 'danger' : 'warning') }}">
                                    {{ $p->status_payment }}
                                </span>
                            </td>
                            <td>{{ $p->created_at->format('d M Y') }}</td>
                            <td>
                                @if($p->status_payment == 'PENDING')
                                <button class="btn btn-success btn-sm" onclick="updatePayment({{ $p->id }}, 'VERIFIED')">
                                    <i class="fas fa-check"></i> Verifikasi
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="updatePayment({{ $p->id }}, 'REJECTED')">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                                @else
                                <span class="text-muted">Sudah diproses</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function updatePayment(id, status) {
    if (confirm('Yakin ingin ' + (status === 'VERIFIED' ? 'memverifikasi' : 'menolak') + ' pembayaran ini?')) {
        fetch(`/keuangan/payment/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}
</script>
@endsection