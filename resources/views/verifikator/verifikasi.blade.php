@extends('layouts.main')

@section('title', 'Verifikasi Administrasi - PPDB Online')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Verifikasi Administrasi</h5>
            <small>Cek data & berkas; tandai Lulus/Tolak/Perbaikan dengan catatan</small>
        </div>
        <div class="card-body">
            @foreach($pendaftar as $p)
            <div class="card mb-4 border-start border-4 border-{{ $p->status_berkas == 'VERIFIED' && $p->status_data == 'VERIFIED' ? 'success' : ($p->status_berkas == 'REJECTED' || $p->status_data == 'REJECTED' ? 'danger' : 'warning') }}">
                <div class="card-header bg-light">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-1"><strong>{{ $p->user->name }}</strong></h6>
                            <small class="text-muted">{{ $p->no_pendaftaran ?? 'Belum Ada' }} | {{ $p->jurusan->nama ?? 'Belum Pilih' }} | {{ $p->created_at->format('d M Y H:i') }}</small>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge bg-{{ $p->status_berkas == 'VERIFIED' ? 'success' : ($p->status_berkas == 'REJECTED' ? 'danger' : 'warning') }} me-1">Berkas: {{ $p->status_berkas }}</span>
                            <span class="badge bg-{{ $p->status_data == 'VERIFIED' ? 'success' : ($p->status_data == 'REJECTED' ? 'danger' : 'warning') }}">Data: {{ $p->status_data }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Data Pribadi -->
                        <div class="col-md-4">
                            <h6 class="text-primary"><i class="fas fa-user me-2"></i>Data Pribadi</h6>
                            @if($p->dataSiswa)
                            <div class="small">
                                <div><strong>Nama:</strong> {{ $p->dataSiswa->nama_lengkap }}</div>
                                <div><strong>NIK:</strong> {{ $p->dataSiswa->nik ?? '-' }}</div>
                                <div><strong>Tempat/Tgl Lahir:</strong> {{ $p->dataSiswa->tempat_lahir ?? '-' }}, {{ $p->dataSiswa->tanggal_lahir ?? '-' }}</div>
                                <div><strong>Alamat:</strong> {{ $p->dataSiswa->alamat ?? '-' }}</div>
                                <div><strong>No. HP:</strong> {{ $p->dataSiswa->no_hp ?? '-' }}</div>
                            </div>
                            @else
                            <div class="text-danger small">Data pribadi belum lengkap</div>
                            @endif
                        </div>
                        
                        <!-- Data Orang Tua -->
                        <div class="col-md-4">
                            <h6 class="text-success"><i class="fas fa-users me-2"></i>Data Orang Tua</h6>
                            @if($p->dataOrtu)
                            <div class="small">
                                <div><strong>Ayah:</strong> {{ $p->dataOrtu->nama_ayah ?? '-' }}</div>
                                <div><strong>Pekerjaan:</strong> {{ $p->dataOrtu->pekerjaan_ayah ?? '-' }}</div>
                                <div><strong>Ibu:</strong> {{ $p->dataOrtu->nama_ibu ?? '-' }}</div>
                                <div><strong>Pekerjaan:</strong> {{ $p->dataOrtu->pekerjaan_ibu ?? '-' }}</div>
                                <div><strong>No. HP:</strong> {{ $p->dataOrtu->no_hp_ortu ?? '-' }}</div>
                            </div>
                            @else
                            <div class="text-danger small">Data orang tua belum lengkap</div>
                            @endif
                        </div>
                        
                        <!-- Berkas -->
                        <div class="col-md-4">
                            <h6 class="text-warning"><i class="fas fa-file-alt me-2"></i>Berkas Upload</h6>
                            @php
                                $berkasTypes = ['IJAZAH', 'KTP', 'KK', 'FOTO'];
                                $uploadedBerkas = $p->berkas && $p->berkas->count() > 0 ? $p->berkas->pluck('jenis')->toArray() : [];
                            @endphp
                            <div class="small">
                                @foreach($berkasTypes as $type)
                                    @if(in_array($type, $uploadedBerkas))
                                        <div><i class="fas fa-check text-success"></i> {{ ucfirst(strtolower($type)) }}</div>
                                    @else
                                        <div><i class="fas fa-times text-danger"></i> {{ ucfirst(strtolower($type)) }}</div>
                                    @endif
                                @endforeach
                                <div class="mt-2">
                                    <small class="text-muted">Total: {{ count($uploadedBerkas) }}/4 berkas</small>
                                    <a href="/verifikator/detail/{{ $p->id }}" class="btn btn-sm btn-outline-info ms-2">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Verifikasi Actions -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="border-top pt-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Verifikasi Berkas</h6>
                                        <div class="btn-group w-100" role="group">
                                            <button class="btn btn-success btn-sm" onclick="showVerificationModal({{ $p->id }}, 'berkas', 'VERIFIED')" {{ $p->status_berkas != 'PENDING' ? 'disabled' : '' }}>
                                                <i class="fas fa-check"></i> Lulus
                                            </button>
                                            <button class="btn btn-warning btn-sm" onclick="showVerificationModal({{ $p->id }}, 'berkas', 'REVISION')" {{ $p->status_berkas != 'PENDING' ? 'disabled' : '' }}>
                                                <i class="fas fa-edit"></i> Perbaikan
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="showVerificationModal({{ $p->id }}, 'berkas', 'REJECTED')" {{ $p->status_berkas != 'PENDING' ? 'disabled' : '' }}>
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Verifikasi Data</h6>
                                        <div class="btn-group w-100" role="group">
                                            <button class="btn btn-success btn-sm" onclick="showVerificationModal({{ $p->id }}, 'data', 'VERIFIED')" {{ $p->status_data != 'PENDING' ? 'disabled' : '' }}>
                                                <i class="fas fa-check"></i> Lulus
                                            </button>
                                            <button class="btn btn-warning btn-sm" onclick="showVerificationModal({{ $p->id }}, 'data', 'REVISION')" {{ $p->status_data != 'PENDING' ? 'disabled' : '' }}>
                                                <i class="fas fa-edit"></i> Perbaikan
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="showVerificationModal({{ $p->id }}, 'data', 'REJECTED')" {{ $p->status_data != 'PENDING' ? 'disabled' : '' }}>
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @if($p->catatan_verifikasi)
                                <div class="mt-2">
                                    <small class="text-muted"><strong>Catatan:</strong> {{ $p->catatan_verifikasi }}</small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Verification Modal -->
<div class="modal fade" id="verificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi <span id="modalType"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="verificationForm">
                    <input type="hidden" id="pendaftarId">
                    <input type="hidden" id="verificationType">
                    <input type="hidden" id="verificationStatus">
                    
                    <div class="mb-3">
                        <label class="form-label">Status Verifikasi</label>
                        <div id="statusDisplay" class="form-control-plaintext"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="catatan" rows="3" placeholder="Berikan catatan verifikasi..." required></textarea>
                        <div class="form-text">Jelaskan alasan verifikasi atau perbaikan yang diperlukan</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitVerification()">Simpan Verifikasi</button>
            </div>
        </div>
    </div>
</div>

<script>
function showVerificationModal(id, type, status) {
    document.getElementById('pendaftarId').value = id;
    document.getElementById('verificationType').value = type;
    document.getElementById('verificationStatus').value = status;
    
    const typeText = type === 'berkas' ? 'Berkas' : 'Data';
    const statusText = status === 'VERIFIED' ? 'Lulus' : (status === 'REVISION' ? 'Perbaikan' : 'Tolak');
    const statusClass = status === 'VERIFIED' ? 'success' : (status === 'REVISION' ? 'warning' : 'danger');
    
    document.getElementById('modalType').textContent = typeText;
    document.getElementById('statusDisplay').innerHTML = `<span class="badge bg-${statusClass}">${statusText}</span>`;
    document.getElementById('catatan').value = '';
    
    new bootstrap.Modal(document.getElementById('verificationModal')).show();
}

function submitVerification() {
    const id = document.getElementById('pendaftarId').value;
    const type = document.getElementById('verificationType').value;
    const status = document.getElementById('verificationStatus').value;
    const catatan = document.getElementById('catatan').value;
    
    if (!catatan.trim()) {
        alert('Catatan harus diisi!');
        return;
    }
    
    const endpoint = type === 'berkas' ? `/verifikator/berkas/${id}` : `/verifikator/data/${id}`;
    
    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status: status, catatan: catatan })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('verificationModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}
</script>
@endsection