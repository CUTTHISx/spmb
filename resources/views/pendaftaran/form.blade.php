@extends('layouts.main')

@section('title', 'Form Pendaftaran - PPDB Online')

@section('content')
<div class="container mt-4">
    <!-- Progress Steps -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="step-item active">
                            <div class="step-number">1</div>
                            <div class="step-label">Data Siswa</div>
                        </div>
                        <div class="step-line"></div>
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-label">Data Orang Tua</div>
                        </div>
                        <div class="step-line"></div>
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-label">Asal Sekolah</div>
                        </div>
                        <div class="step-line"></div>
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <div class="step-label">Upload Berkas</div>
                        </div>
                        <div class="step-line"></div>
                        <div class="step-item">
                            <div class="step-number">5</div>
                            <div class="step-label">Pembayaran</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="/pendaftaran/store" method="POST" id="pendaftaranForm" enctype="multipart/form-data">
        @csrf
        
        <!-- Step 1: Data Siswa -->
        <div class="card mb-4 step-content" id="step1">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Data Siswa</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pilih Jurusan <span class="text-danger">*</span></label>
                        <select class="form-select" name="jurusan_id" required>
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusan as $j)
                            <option value="{{ $j->id }}" {{ $pendaftar && $pendaftar->jurusan_id == $j->id ? 'selected' : '' }}>
                                {{ $j->nama }} (Kuota: {{ $j->kuota }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nik" maxlength="16" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NISN <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nisn" maxlength="10" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select" name="jk" required>
                            <option value="">Pilih</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tmp_lahir" required>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_lahir" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="alamat" rows="3" required></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">RT/RW</label>
                        <input type="text" class="form-control" name="rt_rw" placeholder="001/002">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Wilayah <span class="text-danger">*</span></label>
                        <select class="form-select" name="wilayah_id" required>
                            <option value="">Pilih Wilayah</option>
                            @foreach(\App\Models\Wilayah::all() as $w)
                            <option value="{{ $w->id }}">{{ $w->kecamatan }}, {{ $w->kelurahan }} - {{ $w->kodepos }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Koordinat Lokasi</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="koordinat" name="koordinat" readonly placeholder="Klik tombol untuk ambil lokasi">
                            <button type="button" class="btn btn-outline-primary" id="getLocationBtn">
                                <i class="fas fa-map-marker-alt"></i> Ambil Lokasi
                            </button>
                        </div>
                        <small class="text-muted">Koordinat akan digunakan untuk peta sebaran pendaftar</small>
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Data Orang Tua -->
        <div class="card mb-4 step-content d-none" id="step2">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Data Orang Tua</h5>
            </div>
            <div class="card-body">
                <h6 class="text-primary mb-3">Data Ayah</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Ayah</label>
                        <input type="text" class="form-control" name="nama_ayah">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pekerjaan Ayah</label>
                        <input type="text" class="form-control" name="pekerjaan_ayah">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">No. HP Ayah</label>
                        <input type="tel" class="form-control" name="hp_ayah">
                    </div>
                </div>

                <h6 class="text-primary mb-3 mt-4">Data Ibu</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Ibu</label>
                        <input type="text" class="form-control" name="nama_ibu">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pekerjaan Ibu</label>
                        <input type="text" class="form-control" name="pekerjaan_ibu">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">No. HP Ibu</label>
                        <input type="tel" class="form-control" name="hp_ibu">
                    </div>
                </div>

                <h6 class="text-primary mb-3 mt-4">Data Wali (Opsional)</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Wali</label>
                        <input type="text" class="form-control" name="wali_nama">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No. HP Wali</label>
                        <input type="tel" class="form-control" name="wali_hp">
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Asal Sekolah -->
        <div class="card mb-4 step-content d-none" id="step3">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-school me-2"></i>Data Asal Sekolah</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NPSN Sekolah</label>
                        <input type="text" class="form-control" name="npsn">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_sekolah" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kabupaten Asal Sekolah</label>
                        <input type="text" class="form-control" name="kabupaten">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nilai Rata-rata Rapor</label>
                        <input type="number" class="form-control" name="nilai_rata" step="0.01" min="0" max="100">
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Upload Berkas -->
        <div class="card mb-4 step-content d-none" id="step4">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-file-upload me-2"></i>Upload Berkas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ijazah/Rapor SMP <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="ijazah" accept=".pdf,.jpg,.jpeg,.png" required>
                        <small class="text-muted">Format: PDF, JPG, PNG. Max: 2MB</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kartu Keluarga <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="kk" accept=".pdf,.jpg,.jpeg,.png" required>
                        <small class="text-muted">Format: PDF, JPG, PNG. Max: 2MB</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Akta Kelahiran <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="akta" accept=".pdf,.jpg,.jpeg,.png" required>
                        <small class="text-muted">Format: PDF, JPG, PNG. Max: 2MB</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pas Foto 3x4 <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="foto" accept=".jpg,.jpeg,.png" required>
                        <small class="text-muted">Format: JPG, PNG. Max: 1MB</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">KIP/KKS (Opsional)</label>
                        <input type="file" class="form-control" name="kip" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Format: PDF, JPG, PNG. Max: 2MB</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Surat Keterangan Sehat</label>
                        <input type="file" class="form-control" name="surat_sehat" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Format: PDF, JPG, PNG. Max: 2MB</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 5: Pembayaran -->
        <div class="card mb-4 step-content d-none" id="step5">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Informasi Pembayaran</h6>
                    <p class="mb-2">Biaya pendaftaran: <strong>Rp 150.000</strong></p>
                    <p class="mb-0">Silakan transfer ke rekening berikut:</p>
                </div>
                
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Bank BRI</strong><br>
                                No. Rekening: <strong>1234-5678-9012</strong><br>
                                Atas Nama: <strong>PPDB SMK Negeri 1</strong>
                            </div>
                            <div class="col-md-6">
                                <strong>Bank Mandiri</strong><br>
                                No. Rekening: <strong>9876-5432-1098</strong><br>
                                Atas Nama: <strong>PPDB SMK Negeri 1</strong>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6>Upload Bukti Pembayaran</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bukti Transfer <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="bukti_bayar" accept=".pdf,.jpg,.jpeg,.png" required>
                            <small class="text-muted">Format: PDF, JPG, PNG. Max: 2MB</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nominal Transfer <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="nominal" value="150000" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Transfer <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tgl_bayar" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Pengirim <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_pengirim" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="/dashboard/pendaftar" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                        </a>
                        <button type="button" class="btn btn-outline-secondary ms-2 d-none" id="prevBtn">
                            <i class="fas fa-chevron-left me-2"></i>Sebelumnya
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" id="nextBtn">
                            Selanjutnya<i class="fas fa-chevron-right ms-2"></i>
                        </button>
                        <button type="submit" class="btn btn-success d-none" id="submitBtn">
                            <i class="fas fa-paper-plane me-2"></i>Submit Pendaftaran
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.step-item {
    text-align: center;
    flex: 1;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 8px;
    font-weight: bold;
}

.step-item.active .step-number {
    background: var(--primary-color);
    color: white;
}

.step-item.completed .step-number {
    background: #28a745;
    color: white;
}

.step-line {
    height: 2px;
    background: #e9ecef;
    flex: 1;
    margin: 0 20px;
    align-self: center;
    margin-top: -20px;
}

.step-label {
    font-size: 0.9rem;
    color: #6c757d;
}

.step-item.active .step-label {
    color: var(--primary-color);
    font-weight: 600;
}
</style>

<script>
let currentStep = 1;
const totalSteps = 5;
const userId = {{ Auth::id() }};

// Auto-save functionality
function saveFormData() {
    const formData = new FormData(document.getElementById('pendaftaranForm'));
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        if (value instanceof File) continue;
        data[key] = value;
    }
    
    localStorage.setItem(`ppdb_form_${userId}`, JSON.stringify(data));
}

function loadFormData() {
    const savedData = localStorage.getItem(`ppdb_form_${userId}`);
    if (savedData) {
        const data = JSON.parse(savedData);
        
        Object.keys(data).forEach(key => {
            const input = document.querySelector(`[name="${key}"]`);
            if (input && input.type !== 'file') {
                input.value = data[key];
            }
        });
    }
}

function setupAutoSave() {
    const form = document.getElementById('pendaftaranForm');
    const inputs = form.querySelectorAll('input:not([type="file"]), select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('change', saveFormData);
    });
}

function showStep(step) {
    for (let i = 1; i <= totalSteps; i++) {
        document.getElementById(`step${i}`).classList.add('d-none');
        document.querySelector(`.step-item:nth-child(${i * 2 - 1})`).classList.remove('active', 'completed');
    }
    
    document.getElementById(`step${step}`).classList.remove('d-none');
    
    for (let i = 1; i < step; i++) {
        document.querySelector(`.step-item:nth-child(${i * 2 - 1})`).classList.add('completed');
    }
    document.querySelector(`.step-item:nth-child(${step * 2 - 1})`).classList.add('active');
    
    document.getElementById('prevBtn').classList.toggle('d-none', step === 1);
    document.getElementById('nextBtn').classList.toggle('d-none', step === totalSteps);
    document.getElementById('submitBtn').classList.toggle('d-none', step !== totalSteps);
}

document.getElementById('nextBtn').addEventListener('click', function() {
    saveFormData();
    if (currentStep < totalSteps) {
        currentStep++;
        showStep(currentStep);
    }
});

document.getElementById('prevBtn').addEventListener('click', function() {
    saveFormData();
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
    }
});

document.getElementById('pendaftaranForm').addEventListener('submit', function() {
    localStorage.removeItem(`ppdb_form_${userId}`);
});

showStep(1);
loadFormData();
setupAutoSave();

if (localStorage.getItem(`ppdb_form_${userId}`)) {
    const notification = document.createElement('div');
    notification.className = 'alert alert-info alert-dismissible fade show mt-3';
    notification.innerHTML = `<i class="fas fa-info-circle me-2"></i>Data yang sudah diisi sebelumnya telah dipulihkan. <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    document.querySelector('.container').insertBefore(notification, document.querySelector('.container').firstChild);
}

// Geolocation functionality
document.getElementById('getLocationBtn').addEventListener('click', function() {
    const btn = this;
    const koordinatInput = document.getElementById('koordinat');
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    
    if (!navigator.geolocation) {
        alert('Geolocation tidak didukung oleh browser ini.');
        return;
    }
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengambil...';
    btn.disabled = true;
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            latInput.value = lat;
            lngInput.value = lng;
            koordinatInput.value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            
            btn.innerHTML = '<i class="fas fa-check"></i> Berhasil';
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-success');
            
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-map-marker-alt"></i> Ambil Lokasi';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-primary');
                btn.disabled = false;
            }, 2000);
        },
        function(error) {
            let errorMsg = 'Gagal mengambil lokasi.';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMsg = 'Akses lokasi ditolak. Silakan izinkan akses lokasi.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMsg = 'Informasi lokasi tidak tersedia.';
                    break;
                case error.TIMEOUT:
                    errorMsg = 'Timeout saat mengambil lokasi.';
                    break;
            }
            
            alert(errorMsg);
            btn.innerHTML = '<i class="fas fa-map-marker-alt"></i> Ambil Lokasi';
            btn.disabled = false;
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 60000
        }
    );
});
</script>
@endsection