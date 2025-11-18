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
                        <select class="form-select" name="jurusan_id" required id="jurusanSelect">
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusan as $j)
                            @php
                                $sisaKuota = $j->kuota - $j->pendaftar_count;
                                $isSelected = $pendaftar && $pendaftar->jurusan_id == $j->id;
                                $isDisabled = $sisaKuota <= 0 && !$isSelected;
                            @endphp
                            <option value="{{ $j->id }}" 
                                {{ $isSelected ? 'selected' : '' }}
                                {{ $isDisabled ? 'disabled class="quota-full"' : '' }}
                                data-quota="{{ $sisaKuota }}">
                                {{ $j->nama }} 
                                @if($isDisabled)
                                    - KUOTA PENUH ({{ $j->pendaftar_count }}/{{ $j->kuota }})
                                @else
                                    (Sisa: {{ $sisaKuota }}/{{ $j->kuota }})
                                @endif
                            </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Jurusan dengan tanda "KUOTA PENUH" tidak dapat dipilih</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nik" maxlength="16" value="{{ $pendaftar && $pendaftar->dataSiswa ? $pendaftar->dataSiswa->nik : '' }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NISN <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nisn" maxlength="10" value="{{ $pendaftar && $pendaftar->dataSiswa ? $pendaftar->dataSiswa->nisn : '' }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama" value="{{ $pendaftar && $pendaftar->dataSiswa ? $pendaftar->dataSiswa->nama : '' }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select" name="jk" required>
                            <option value="">Pilih</option>
                            <option value="L" {{ $pendaftar && $pendaftar->dataSiswa && $pendaftar->dataSiswa->jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $pendaftar && $pendaftar->dataSiswa && $pendaftar->dataSiswa->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tmp_lahir" value="{{ $pendaftar && $pendaftar->dataSiswa ? $pendaftar->dataSiswa->tmp_lahir : '' }}" required>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_lahir" value="{{ $pendaftar && $pendaftar->dataSiswa ? $pendaftar->dataSiswa->tgl_lahir : '' }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="alamat" rows="3" required>{{ $pendaftar && $pendaftar->dataSiswa ? $pendaftar->dataSiswa->alamat : '' }}</textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">RT/RW</label>
                        <input type="text" class="form-control" name="rt_rw" value="{{ $pendaftar && $pendaftar->dataSiswa ? $pendaftar->dataSiswa->rt_rw : '' }}" placeholder="001/002">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Wilayah <span class="text-danger">*</span></label>
                        <select class="form-select" name="wilayah_id" required>
                            <option value="">Pilih Wilayah</option>
                            @foreach(\App\Models\Wilayah::all() as $w)
                            <option value="{{ $w->id }}" {{ $pendaftar && $pendaftar->dataSiswa && $pendaftar->dataSiswa->wilayah_id == $w->id ? 'selected' : '' }}>
                                {{ $w->provinsi }}, {{ $w->kabupaten }}, {{ $w->kecamatan }}, {{ $w->kelurahan }} - {{ $w->kodepos }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Koordinat Lokasi</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="koordinat" name="koordinat" readonly placeholder="Klik tombol untuk pilih lokasi di peta" value="@if($pendaftar && $pendaftar->dataSiswa && $pendaftar->dataSiswa->lat && $pendaftar->dataSiswa->lng){{ $pendaftar->dataSiswa->lat }}, {{ $pendaftar->dataSiswa->lng }}@endif">
                            <button type="button" class="btn btn-outline-primary" id="openMapBtn" data-bs-toggle="modal" data-bs-target="#mapModal">
                                <i class="fas fa-map-marker-alt"></i> Pilih di Peta
                            </button>
                        </div>
                        <small class="text-muted">Klik pada peta untuk menentukan lokasi rumah Anda</small>
                        <input type="hidden" name="latitude" id="latitude" value="{{ $pendaftar && $pendaftar->dataSiswa ? $pendaftar->dataSiswa->lat : '' }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ $pendaftar && $pendaftar->dataSiswa ? $pendaftar->dataSiswa->lng : '' }}">
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
                        <input type="text" class="form-control" name="nama_ayah" value="{{ $pendaftar && $pendaftar->dataOrtu ? $pendaftar->dataOrtu->nama_ayah : '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pekerjaan Ayah</label>
                        <input type="text" class="form-control" name="pekerjaan_ayah" value="{{ $pendaftar && $pendaftar->dataOrtu ? $pendaftar->dataOrtu->pekerjaan_ayah : '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">No. HP Ayah</label>
                        <input type="tel" class="form-control" name="hp_ayah" value="{{ $pendaftar && $pendaftar->dataOrtu ? $pendaftar->dataOrtu->hp_ayah : '' }}">
                    </div>
                </div>

                <h6 class="text-primary mb-3 mt-4">Data Ibu</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Ibu</label>
                        <input type="text" class="form-control" name="nama_ibu" value="{{ $pendaftar && $pendaftar->dataOrtu ? $pendaftar->dataOrtu->nama_ibu : '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pekerjaan Ibu</label>
                        <input type="text" class="form-control" name="pekerjaan_ibu" value="{{ $pendaftar && $pendaftar->dataOrtu ? $pendaftar->dataOrtu->pekerjaan_ibu : '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">No. HP Ibu</label>
                        <input type="tel" class="form-control" name="hp_ibu" value="{{ $pendaftar && $pendaftar->dataOrtu ? $pendaftar->dataOrtu->hp_ibu : '' }}">
                    </div>
                </div>

                <h6 class="text-primary mb-3 mt-4">Data Wali (Opsional)</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Wali</label>
                        <input type="text" class="form-control" name="wali_nama" value="{{ $pendaftar && $pendaftar->dataOrtu ? $pendaftar->dataOrtu->wali_nama : '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No. HP Wali</label>
                        <input type="tel" class="form-control" name="wali_hp" value="{{ $pendaftar && $pendaftar->dataOrtu ? $pendaftar->dataOrtu->wali_hp : '' }}">
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
                        <input type="text" class="form-control" name="npsn" value="{{ $pendaftar && $pendaftar->asalSekolah ? $pendaftar->asalSekolah->npsn : '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_sekolah" value="{{ $pendaftar && $pendaftar->asalSekolah ? $pendaftar->asalSekolah->nama_sekolah : '' }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kabupaten Asal Sekolah</label>
                        <input type="text" class="form-control" name="kabupaten" value="{{ $pendaftar && $pendaftar->asalSekolah ? $pendaftar->asalSekolah->kabupaten : '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nilai Rata-rata Rapor</label>
                        <input type="number" class="form-control" name="nilai_rata" value="{{ $pendaftar && $pendaftar->asalSekolah ? $pendaftar->asalSekolah->nilai_rata : '' }}" step="0.01" min="0" max="100">
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

<!-- Map Modal -->
<div class="modal fade" id="mapModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Lokasi di Peta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Klik pada peta untuk menentukan lokasi rumah Anda. Marker akan menunjukkan posisi yang dipilih.
                </div>
                <div id="map" style="height: 400px; width: 100%;"></div>
                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="modalLat" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="modalLng" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmLocationBtn">Gunakan Lokasi Ini</button>
            </div>
        </div>
    </div>
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

.step-item.completed .step-number::after {
    content: '\f00c';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    font-size: 0.8rem;
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

/* Styling for disabled jurusan options */
#jurusanSelect option:disabled {
    color: #dc3545 !important;
    background-color: #f8f9fa !important;
    font-style: italic;
}

#jurusanSelect option[disabled] {
    color: #dc3545 !important;
    opacity: 0.6;
}
</style>

<script>
let currentStep = 1;
const totalSteps = 4;
const userId = {{ Auth::id() }};

// Auto-save functionality
function saveFormData() {
    const form = document.getElementById('pendaftaranForm');
    const formData = new FormData(form);
    const data = {};
    
    // Save non-file inputs to localStorage
    for (let [key, value] of formData.entries()) {
        if (!(value instanceof File)) {
            data[key] = value;
        }
    }
    localStorage.setItem(`ppdb_form_${userId}`, JSON.stringify(data));
    
    // Send all data including files to server
    fetch('/pendaftaran/auto-save', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    }).catch(error => console.log('Auto-save error:', error));
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
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        if (input.type === 'file') {
            // Auto-save files immediately when selected
            input.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const fileName = this.files[0].name;
                    clearFieldError(this);
                    
                    // Show upload indicator
                    const indicator = document.createElement('small');
                    indicator.className = 'text-success d-block mt-1';
                    indicator.innerHTML = `<i class="fas fa-check-circle"></i> ${fileName} siap diupload`;
                    
                    // Remove existing indicator
                    const existing = this.parentNode.querySelector('.text-success');
                    if (existing) existing.remove();
                    
                    this.parentNode.appendChild(indicator);
                    
                    // Auto-save the file
                    saveFormData();
                }
            });
        } else if (input.type === 'date') {
            // Auto-save dates immediately when changed
            input.addEventListener('change', function() {
                if (this.value) {
                    clearFieldError(this);
                    
                    // Show save indicator
                    const indicator = document.createElement('small');
                    indicator.className = 'text-success d-block mt-1';
                    indicator.innerHTML = `<i class="fas fa-check-circle"></i> Tanggal tersimpan`;
                    
                    // Remove existing indicator
                    const existing = this.parentNode.querySelector('.text-success');
                    if (existing) existing.remove();
                    
                    this.parentNode.appendChild(indicator);
                    
                    // Remove indicator after 2 seconds
                    setTimeout(() => {
                        if (indicator.parentNode) {
                            indicator.remove();
                        }
                    }, 2000);
                }
                saveFormData();
            });
        } else {
            // Real-time validation for other inputs
            input.addEventListener('input', function() {
                if (this.value.trim()) {
                    clearFieldError(this);
                }
            });
            
            input.addEventListener('change', function() {
                if (this.value.trim()) {
                    clearFieldError(this);
                }
                saveFormData();
            });
            
            input.addEventListener('blur', saveFormData);
        }
    });
}

function showStep(step) {
    // Clear all field errors when changing steps
    clearAllErrors();
    
    for (let i = 1; i <= totalSteps; i++) {
        document.getElementById(`step${i}`).classList.add('d-none');
        document.querySelector(`.step-item:nth-child(${i * 2 - 1})`).classList.remove('active', 'completed');
    }
    
    document.getElementById(`step${step}`).classList.remove('d-none');
    
    // Mark completed steps
    for (let i = 1; i < step; i++) {
        if (isStepCompleted(i)) {
            document.querySelector(`.step-item:nth-child(${i * 2 - 1})`).classList.add('completed');
        }
    }
    document.querySelector(`.step-item:nth-child(${step * 2 - 1})`).classList.add('active');
    
    document.getElementById('prevBtn').classList.toggle('d-none', step === 1);
    document.getElementById('nextBtn').classList.toggle('d-none', step === totalSteps);
    document.getElementById('submitBtn').classList.toggle('d-none', step !== totalSteps);
}

function isStepCompleted(stepNumber) {
    switch(stepNumber) {
        case 1: return validateStep1();
        case 2: return true; // Optional step
        case 3: return validateStep3();
        case 4: return validateStep4();
        default: return false;
    }
}

document.getElementById('nextBtn').addEventListener('click', function() {
    if (validateCurrentStep()) {
        saveFormData();
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    }
});

document.getElementById('prevBtn').addEventListener('click', function() {
    saveFormData();
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
    }
});

document.getElementById('pendaftaranForm').addEventListener('submit', function(e) {
    // Validate all steps before submission
    const stepValidations = [
        { step: 1, valid: validateStep1() },
        { step: 2, valid: validateStep2() },
        { step: 3, valid: validateStep3() },
        { step: 4, valid: validateStep4() }
    ];
    
    const invalidStep = stepValidations.find(s => !s.valid);
    
    if (invalidStep) {
        e.preventDefault();
        // Go to first invalid step
        currentStep = invalidStep.step;
        showStep(currentStep);
        
        // Show general error
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger alert-dismissible fade show mt-3';
        errorDiv.innerHTML = `
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Validasi Gagal!</strong> Mohon periksa dan lengkapi data yang ditandai merah.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const currentStepDiv = document.getElementById(`step${currentStep}`);
        currentStepDiv.insertBefore(errorDiv, currentStepDiv.querySelector('.card-body'));
        
        return false;
    }
    
    // Show loading state
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
    submitBtn.disabled = true;
    
    localStorage.removeItem(`ppdb_form_${userId}`);
});



// Step validation functions
function validateStep1() {
    const requiredFields = ['jurusan_id', 'nik', 'nisn', 'nama', 'jk', 'tmp_lahir', 'tgl_lahir', 'alamat', 'wilayah_id'];
    return validateFields(requiredFields, 'Data Siswa');
}

function validateStep2() {
    // Step 2 is optional, always return true
    return true;
}

function validateStep3() {
    const requiredFields = ['nama_sekolah'];
    return validateFields(requiredFields, 'Data Asal Sekolah');
}

function validateStep4() {
    const requiredFiles = ['ijazah', 'kk', 'akta', 'foto'];
    let isValid = true;
    
    requiredFiles.forEach(field => {
        const fileInput = document.querySelector(`input[name="${field}"]`);
        if (!fileInput.files.length) {
            showFieldError(fileInput, 'File wajib diupload');
            isValid = false;
        } else {
            clearFieldError(fileInput);
        }
    });
    
    return isValid;
}



function validateFields(fieldNames, stepName) {
    let isValid = true;
    
    fieldNames.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field && (!field.value || field.value.trim() === '')) {
            showFieldError(field, 'Field ini wajib diisi');
            isValid = false;
        } else if (field) {
            clearFieldError(field);
        }
    });
    
    return isValid;
}

function getFieldLabel(field) {
    const label = field.closest('.mb-3')?.querySelector('label');
    if (label) {
        return label.textContent.replace('*', '').trim();
    }
    return field.name;
}

function getFileLabel(fieldName) {
    const labels = {
        'ijazah': 'Ijazah/Rapor SMP',
        'kk': 'Kartu Keluarga',
        'akta': 'Akta Kelahiran',
        'foto': 'Pas Foto 3x4',
        'bukti_bayar': 'Bukti Pembayaran'
    };
    return labels[fieldName] || fieldName;
}

function validateCurrentStep() {
    switch(currentStep) {
        case 1: return validateStep1();
        case 2: return validateStep2();
        case 3: return validateStep3();
        case 4: return validateStep4();
        default: return true;
    }
}

function showFieldError(field, message) {
    // Remove existing error for this field
    clearFieldError(field);
    
    // Add error class to field
    field.classList.add('is-invalid');
    
    // Create error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback';
    errorDiv.textContent = message;
    
    // Insert error message after field
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('is-invalid');
    const errorDiv = field.parentNode.querySelector('.invalid-feedback');
    if (errorDiv) {
        errorDiv.remove();
    }
}

function clearAllErrors() {
    document.querySelectorAll('.is-invalid').forEach(field => {
        clearFieldError(field);
    });
}

showStep(1);
loadFormData();
setupAutoSave();

// Add warning for full quota jurusan
document.getElementById('jurusanSelect').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.disabled) {
        alert('Maaf, kuota untuk jurusan ' + selectedOption.text.split(' - ')[0] + ' sudah penuh!');
        this.value = '';
    }
});

// Show auto-save notification if data exists
@if($pendaftar)
const autoSaveNotification = document.createElement('div');
autoSaveNotification.className = 'alert alert-info alert-dismissible fade show mt-3';
autoSaveNotification.innerHTML = `
    <i class="fas fa-info-circle me-2"></i>Data pendaftaran Anda tersimpan otomatis. 
    <strong>Terakhir diperbarui:</strong> {{ $pendaftar->updated_at->format('d M Y H:i') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
`;
document.querySelector('.container').insertBefore(autoSaveNotification, document.querySelector('.container').firstChild);
@endif

if (localStorage.getItem(`ppdb_form_${userId}`)) {
    const notification = document.createElement('div');
    notification.className = 'alert alert-info alert-dismissible fade show mt-3';
    notification.innerHTML = `<i class="fas fa-info-circle me-2"></i>Data yang sudah diisi sebelumnya telah dipulihkan. <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    document.querySelector('.container').insertBefore(notification, document.querySelector('.container').firstChild);
}

// Map functionality
let map;
let marker;
let selectedLat = null;
let selectedLng = null;

// Initialize map when modal is shown
document.getElementById('mapModal').addEventListener('shown.bs.modal', function() {
    if (!map) {
        // Default to Bandung coordinates
        const defaultLat = -6.9175;
        const defaultLng = 107.6191;
        
        // Check if there's existing coordinates
        const existingLat = document.getElementById('latitude').value;
        const existingLng = document.getElementById('longitude').value;
        
        const initialLat = existingLat ? parseFloat(existingLat) : defaultLat;
        const initialLng = existingLng ? parseFloat(existingLng) : defaultLng;
        
        map = L.map('map').setView([initialLat, initialLng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        // Add existing marker if coordinates exist
        if (existingLat && existingLng) {
            marker = L.marker([initialLat, initialLng]).addTo(map);
            selectedLat = initialLat;
            selectedLng = initialLng;
            document.getElementById('modalLat').value = initialLat.toFixed(6);
            document.getElementById('modalLng').value = initialLng.toFixed(6);
        }
        
        // Add click event to map
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            
            // Remove existing marker
            if (marker) {
                map.removeLayer(marker);
            }
            
            // Add new marker
            marker = L.marker([lat, lng]).addTo(map);
            
            // Update coordinates
            selectedLat = lat;
            selectedLng = lng;
            document.getElementById('modalLat').value = lat.toFixed(6);
            document.getElementById('modalLng').value = lng.toFixed(6);
        });
        
        // Prevent selection of disabled options
        document.getElementById('jurusanSelect').addEventListener('mousedown', function(e) {
            if (e.target.disabled) {
                e.preventDefault();
                return false;
            }
        });
    }
    
    // Refresh map size
    setTimeout(() => {
        map.invalidateSize();
    }, 200);
});

// Confirm location button
document.getElementById('confirmLocationBtn').addEventListener('click', function() {
    if (selectedLat && selectedLng) {
        document.getElementById('latitude').value = selectedLat;
        document.getElementById('longitude').value = selectedLng;
        document.getElementById('koordinat').value = `${selectedLat.toFixed(6)}, ${selectedLng.toFixed(6)}`;
        
        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('mapModal')).hide();
        
        // Show success message
        const btn = document.getElementById('openMapBtn');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Lokasi Dipilih';
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-success');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-primary');
        }, 2000);
    } else {
        alert('Silakan klik pada peta untuk memilih lokasi.');
    }
});
</script>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection