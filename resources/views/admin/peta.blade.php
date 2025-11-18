@extends('layouts.main')

@section('title', 'Peta Sebaran Pendaftar - PPDB Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/layouts/dashboard.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
#map { height: 500px; width: 100%; }
.info-panel { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.legend { background: white; padding: 10px; border-radius: 5px; }
.legend i { width: 18px; height: 18px; float: left; margin-right: 8px; opacity: 0.7; }

.custom-popup .leaflet-popup-content {
    margin: 8px 12px;
    line-height: 1.4;
}

.marker-popup {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.marker-popup h6 {
    color: #2c3e50;
    border-bottom: 2px solid #3498db;
    padding-bottom: 5px;
    margin-bottom: 10px;
}

.marker-popup .badge {
    font-size: 0.75em;
    padding: 4px 8px;
    border-radius: 12px;
    color: white;
}

.marker-popup p {
    margin-bottom: 5px;
    font-size: 0.9em;
}

.marker-popup hr {
    margin: 8px 0;
    border-color: #ecf0f1;
}

.leaflet-popup-content-wrapper {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.realtime-indicator {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1000;
    background: rgba(255,255,255,0.9);
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 0.8em;
}

.realtime-indicator.active {
    background: rgba(40, 167, 69, 0.9);
    color: white;
}

.pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Stats Overview -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold" id="totalPendaftar">0</h3>
                            <p class="text-muted mb-0">Total Pendaftar</p>
                        </div>
                        <div class="stat-icon bg-primary-light">
                            <i class="fas fa-users text-primary fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold" id="totalKecamatan">0</h3>
                            <p class="text-muted mb-0">Kecamatan</p>
                        </div>
                        <div class="stat-icon bg-success-light">
                            <i class="fas fa-map-marker-alt text-success fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold" id="totalKelurahan">0</h3>
                            <p class="text-muted mb-0">Kelurahan</p>
                        </div>
                        <div class="stat-icon bg-info-light">
                            <i class="fas fa-building text-info fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="fw-bold" id="lastUpdate">-</h3>
                            <p class="text-muted mb-0">Update Terakhir</p>
                        </div>
                        <div class="stat-icon bg-warning-light">
                            <i class="fas fa-clock text-warning fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="realtime-indicator badge bg-success" id="realtimeStatus">
                            <i class="fas fa-circle pulse"></i> Live
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card system-status-card">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-map-marked-alt text-primary me-2"></i>
                        Peta Sebaran Pendaftar Real-Time
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Filter Controls -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Filter Jurusan</label>
                            <select class="form-select" id="filterJurusan" onchange="applyFilters()">
                                <option value="">Semua Jurusan</option>
                                <option value="PPLG">PPLG</option>
                                <option value="AKUNTANSI">Akuntansi</option>
                                <option value="DKV">DKV</option>
                                <option value="ANIMASI">Animasi</option>
                                <option value="BDP">BDP</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Status Pendaftar</label>
                            <select class="form-select" id="filterStatus" onchange="applyFilters()">
                                <option value="">Semua Status</option>
                                <option value="DRAFT">Draft</option>
                                <option value="SUBMITTED">Menunggu Verifikasi</option>
                                <option value="VERIFIED_ADM">Terverifikasi</option>
                                <option value="REJECTED">Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Kontrol Peta</label>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary flex-fill" onclick="refreshMap()">
                                    <i class="fas fa-sync me-1"></i>Refresh
                                </button>
                                <div class="form-check form-switch d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" id="autoRefresh" checked>
                                    <label class="form-check-label ms-2" for="autoRefresh">Auto</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map Container -->
                    <div style="position: relative;">
                        <div id="map"></div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Detail Table -->
    <div class="row">
        <div class="col-12">
            <div class="card system-status-card">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-table text-primary me-2"></i>
                        Detail Sebaran per Wilayah
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="sebaranTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Pendaftar</th>
                                    <th>Email</th>
                                    <th>Jurusan</th>
                                    <th>Status</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten</th>
                                    <th>Kecamatan</th>
                                    <th>Kelurahan</th>
                                    <th>Tanggal Daftar</th>
                                </tr>
                            </thead>
                            <tbody id="sebaranTableBody">
                                <!-- Data will be loaded via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let map;
let markers = [];
let sebaranData = [];
let lastUpdateTimestamp = 0;
let refreshInterval;

// Initialize map
function initMap() {
    map = L.map('map').setView([-6.2088, 106.8456], 8); // Indonesia center
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Add school marker
    L.marker([-6.942100, 107.740300], {
        icon: L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        })
    })
    .addTo(map)
    .bindPopup('<b>SMK Bakti Nusantara 666</b><br>Lokasi Sekolah')
    .openPopup();

    // Add legend
    addLegend();
    
    // Load initial data
    loadSebaranData();
    
    // Start real-time updates
    startRealTimeUpdates();
}

function addLegend() {
    const legend = L.control({position: 'bottomright'});
    
    legend.onAdd = function (map) {
        const div = L.DomUtil.create('div', 'legend');
        div.innerHTML = `
            <h6>Jurusan</h6>
            <i style="background: #ff6b6b"></i> PPLG<br>
            <i style="background: #4ecdc4"></i> DKV<br>
            <i style="background: #45b7d1"></i> Akuntansi<br>
            <i style="background: #f9ca24"></i> Animasi<br>
            <i style="background: #6c5ce7"></i> BDP<br>
            <hr>
            <h6>Status</h6>
            <i style="background: #6c757d"></i> Draft<br>
            <i style="background: #ffc107"></i> Menunggu<br>
            <i style="background: #28a745"></i> Terverifikasi<br>
            <i style="background: #17a2b8"></i> Terbayar<br>
        `;
        return div;
    };
    
    legend.addTo(map);
}

function getJurusanColor(jurusan) {
    const colors = {
        'PPLG': '#ff6b6b',
        'DKV': '#4ecdc4', 
        'AKUNTANSI': '#45b7d1',
        'ANIMASI': '#f9ca24',
        'BDP': '#6c5ce7'
    };
    return colors[jurusan] || '#95a5a6';
}

function getStatusColor(status) {
    const colors = {
        'DRAFT': '#6c757d',
        'SUBMITTED': '#ffc107',
        'VERIFIED_ADM': '#28a745',
        'REJECTED': '#dc3545',
        'PAID': '#17a2b8'
    };
    return colors[status] || '#6c757d';
}

function getStatusText(status) {
    const texts = {
        'DRAFT': 'Draft',
        'SUBMITTED': 'Menunggu Verifikasi',
        'VERIFIED_ADM': 'Terverifikasi',
        'REJECTED': 'Ditolak',
        'PAID': 'Terbayar'
    };
    return texts[status] || 'Unknown';
}

function loadSebaranData() {
    fetch('/admin/api/sebaran-data')
        .then(response => response.json())
        .then(data => {
            sebaranData = data;
            updateMapMarkers();
            updateStatistics();
            updateTable();
            updateLastUpdateTime();
        })
        .catch(error => {
            console.error('Error loading sebaran data:', error);
            document.getElementById('totalPendaftar').textContent = 'Error';
        });
}

function updateMapMarkers() {
    // Clear existing markers (except school marker)
    markers.forEach(marker => map.removeLayer(marker));
    markers = [];
    
    // Apply filters
    const filteredData = applyCurrentFilters();
    
    filteredData.forEach(pendaftar => {
        const statusColor = getStatusColor(pendaftar.status);
        const jurusanColor = getJurusanColor(pendaftar.jurusan_kode);
        
        const marker = L.circleMarker([pendaftar.latitude, pendaftar.longitude], {
            radius: 8,
            fillColor: jurusanColor,
            color: statusColor,
            weight: 3,
            opacity: 1,
            fillOpacity: 0.8
        });
        
        const popupContent = `
            <div class="marker-popup">
                <h6 class="mb-2"><i class="fas fa-user"></i> ${pendaftar.nama}</h6>
                <p class="mb-1"><strong>ID Pendaftaran:</strong> ${pendaftar.id}</p>
                <p class="mb-1"><strong>Email:</strong> ${pendaftar.email}</p>
                <p class="mb-1"><strong>Jurusan:</strong> <span class="badge" style="background-color: ${jurusanColor}">${pendaftar.jurusan}</span></p>
                <p class="mb-1"><strong>Status:</strong> <span class="badge" style="background-color: ${statusColor}">${getStatusText(pendaftar.status)}</span></p>
                <hr class="my-2">
                <p class="mb-1"><strong>Alamat:</strong> ${pendaftar.alamat} ${pendaftar.rt_rw ? ', RT/RW ' + pendaftar.rt_rw : ''}</p>
                <p class="mb-1"><strong>Kelurahan:</strong> ${pendaftar.kelurahan}</p>
                <p class="mb-1"><strong>Kecamatan:</strong> ${pendaftar.kecamatan}</p>
                <p class="mb-1"><strong>Kabupaten:</strong> ${pendaftar.kabupaten}</p>
                <p class="mb-1"><strong>Provinsi:</strong> ${pendaftar.provinsi}</p>
                <p class="mb-1"><strong>Kode Pos:</strong> ${pendaftar.kodepos}</p>
                <hr class="my-2">
                <p class="mb-0"><strong>Tanggal Daftar:</strong> ${pendaftar.tanggal_daftar}</p>
                <small class="text-muted">Koordinat: ${pendaftar.latitude.toFixed(6)}, ${pendaftar.longitude.toFixed(6)}</small>
            </div>
        `;
        
        marker.bindPopup(popupContent, {
            maxWidth: 350,
            className: 'custom-popup'
        });
        
        marker.addTo(map);
        markers.push(marker);
    });
}

function applyCurrentFilters() {
    const filterJurusan = document.getElementById('filterJurusan').value;
    const filterStatus = document.getElementById('filterStatus').value;
    
    return sebaranData.filter(pendaftar => {
        const jurusanMatch = !filterJurusan || pendaftar.jurusan_kode === filterJurusan;
        const statusMatch = !filterStatus || pendaftar.status === filterStatus;
        return jurusanMatch && statusMatch;
    });
}

function applyFilters() {
    updateMapMarkers();
    updateStatistics();
    updateTable();
}

function updateStatistics() {
    const filteredData = applyCurrentFilters();
    const totalPendaftar = filteredData.length;
    const uniqueKecamatan = new Set(filteredData.map(p => p.kecamatan)).size;
    const uniqueKelurahan = new Set(filteredData.map(p => p.kelurahan)).size;
    
    document.getElementById('totalPendaftar').textContent = totalPendaftar;
    document.getElementById('totalKecamatan').textContent = uniqueKecamatan;
    document.getElementById('totalKelurahan').textContent = uniqueKelurahan;
}

function updateTable() {
    const tbody = document.getElementById('sebaranTableBody');
    const filteredData = applyCurrentFilters();
    
    if (filteredData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="10" class="text-center text-muted py-4">
                    <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                    <p>Tidak ada data pendaftar sesuai filter</p>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = filteredData.map(pendaftar => `
        <tr>
            <td><span class="badge bg-primary">${pendaftar.id}</span></td>
            <td>${pendaftar.nama}</td>
            <td>${pendaftar.email}</td>
            <td><span class="badge" style="background-color: ${getJurusanColor(pendaftar.jurusan_kode)}">${pendaftar.jurusan}</span></td>
            <td><span class="badge" style="background-color: ${getStatusColor(pendaftar.status)}">${getStatusText(pendaftar.status)}</span></td>
            <td>${pendaftar.provinsi}</td>
            <td>${pendaftar.kabupaten}</td>
            <td>${pendaftar.kecamatan}</td>
            <td>${pendaftar.kelurahan}</td>
            <td>${pendaftar.tanggal_daftar}</td>
        </tr>
    `).join('');
}

function updateLastUpdateTime() {
    const now = new Date();
    document.getElementById('lastUpdate').textContent = now.toLocaleTimeString('id-ID');
}

function refreshMap() {
    loadSebaranData();
    
    // Visual feedback
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Refreshing...';
    btn.disabled = true;
    
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }, 1000);
}

function startRealTimeUpdates() {
    // Check for updates every 10 seconds
    refreshInterval = setInterval(() => {
        if (document.getElementById('autoRefresh').checked) {
            checkForUpdates();
        }
    }, 10000);
}

function checkForUpdates() {
    fetch('/admin/api/map-update')
        .then(response => response.json())
        .then(data => {
            if (data.last_update > lastUpdateTimestamp) {
                lastUpdateTimestamp = data.last_update;
                loadSebaranData();
                
                // Show notification
                showUpdateNotification();
            }
        })
        .catch(error => {
            console.error('Error checking for updates:', error);
        });
}

function showUpdateNotification() {
    const indicator = document.getElementById('realtimeStatus');
    indicator.classList.add('active');
    indicator.innerHTML = '<i class="fas fa-sync fa-spin"></i> Updated!';
    
    setTimeout(() => {
        indicator.classList.remove('active');
        indicator.innerHTML = '<i class="fas fa-circle pulse"></i> Live';
    }, 2000);
}

// Auto refresh toggle
document.getElementById('autoRefresh').addEventListener('change', function() {
    if (this.checked) {
        startRealTimeUpdates();
    } else {
        clearInterval(refreshInterval);
    }
});

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    initMap();
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (refreshInterval) {
        clearInterval(refreshInterval);
    }
});
</script>
@endsection