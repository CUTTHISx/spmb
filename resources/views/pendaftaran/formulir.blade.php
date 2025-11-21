@extends('layouts.main')

@section('title', 'Formulir Pendaftaran - PPDB Online')

@section('content')
<div class="container mt-4 mb-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-file-alt me-2"></i>Formulir Pendaftaran PPDB</h4>
        </div>
        <div class="card-body">
            <!-- Data Pendaftaran -->
            <div class="mb-4">
                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-id-card me-2"></i>Data Pendaftaran</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">No. Pendaftaran</label>
                        <p class="form-control-plaintext">{{ $pendaftar->no_pendaftaran }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Jurusan Pilihan</label>
                        <p class="form-control-plaintext">{{ $pendaftar->jurusan->nama ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Gelombang</label>
                        <p class="form-control-plaintext">{{ $pendaftar->gelombang->nama ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Tanggal Daftar</label>
                        <p class="form-control-plaintext">{{ $pendaftar->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Pribadi -->
            <div class="mb-4">
                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-user me-2"></i>Data Pribadi</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">NIK</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataSiswa->nik ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">NISN</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataSiswa->nisn ?? '-' }}</p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="fw-bold">Nama Lengkap</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataSiswa->nama ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Jenis Kelamin</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Tempat Lahir</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataSiswa->tmp_lahir ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Tanggal Lahir</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataSiswa->tgl_lahir ?? '-' }}</p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="fw-bold">Alamat</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataSiswa->alamat ?? '-' }}</p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="fw-bold">Wilayah</label>
                        <p class="form-control-plaintext">
                            @if($pendaftar->dataSiswa && $pendaftar->dataSiswa->wilayah)
                                {{ $pendaftar->dataSiswa->wilayah->kelurahan }}, {{ $pendaftar->dataSiswa->wilayah->kecamatan }}, {{ $pendaftar->dataSiswa->wilayah->kabupaten }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Data Orang Tua -->
            <div class="mb-4">
                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-users me-2"></i>Data Orang Tua</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Nama Ayah</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataOrtu->nama_ayah ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Pekerjaan Ayah</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataOrtu->pekerjaan_ayah ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">No. HP Ayah</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataOrtu->hp_ayah ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Nama Ibu</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataOrtu->nama_ibu ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Pekerjaan Ibu</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataOrtu->pekerjaan_ibu ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">No. HP Ibu</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataOrtu->hp_ibu ?? '-' }}</p>
                    </div>
                    @if($pendaftar->dataOrtu && $pendaftar->dataOrtu->wali_nama)
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Nama Wali</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataOrtu->wali_nama ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">No. HP Wali</label>
                        <p class="form-control-plaintext">{{ $pendaftar->dataOrtu->wali_hp ?? '-' }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Data Asal Sekolah -->
            <div class="mb-4">
                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-school me-2"></i>Data Asal Sekolah</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">NPSN</label>
                        <p class="form-control-plaintext">{{ $pendaftar->asalSekolah->npsn ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Nama Sekolah</label>
                        <p class="form-control-plaintext">{{ $pendaftar->asalSekolah->nama_sekolah ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Kabupaten/Kota</label>
                        <p class="form-control-plaintext">{{ $pendaftar->asalSekolah->kabupaten ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Nilai Rata-rata</label>
                        <p class="form-control-plaintext">{{ $pendaftar->asalSekolah->nilai_rata ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Berkas -->
            <div class="mb-4">
                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-file me-2"></i>Berkas yang Diupload</h5>
                <div class="row">
                    @php
                        $jenisLabels = [
                            'IJAZAH' => 'Ijazah/SKHUN',
                            'RAPOR' => 'Rapor Semester Terakhir',
                            'KK' => 'Kartu Keluarga',
                            'AKTA' => 'Akta Kelahiran',
                            'FOTO' => 'Pas Foto 3x4'
                        ];
                        
                        $berkasMap = [];
                        foreach($pendaftar->berkas as $b) {
                            $jenis = $b->jenis;
                            if ($jenis === 'LAINNYA' && strpos($b->nama_file, 'foto') !== false) {
                                $jenis = 'FOTO';
                            }
                            $berkasMap[$jenis] = $b;
                        }
                    @endphp
                    
                    @foreach($jenisLabels as $jenis => $label)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-file fa-2x {{ isset($berkasMap[$jenis]) ? 'text-primary' : 'text-muted' }} mb-2"></i>
                                <h6 class="mb-1">{{ $label }}</h6>
                                @if(isset($berkasMap[$jenis]))
                                    <small class="text-muted d-block">{{ $berkasMap[$jenis]->ukuran_kb }} KB</small>
                                    <span class="badge bg-{{ $berkasMap[$jenis]->status_verifikasi == 'VERIFIED' ? 'success' : 'warning' }} mt-2">
                                        {{ $berkasMap[$jenis]->status_verifikasi }}
                                    </span>
                                @else
                                    <small class="text-muted">-</small>
                                    <span class="badge bg-secondary mt-2">Belum Upload</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-4">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print me-2"></i>Cetak Formulir
                </button>
                <button onclick="window.close()" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .card-header { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>
@endsection
