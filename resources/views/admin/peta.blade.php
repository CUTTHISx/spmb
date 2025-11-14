@extends('layouts.main')

@section('title', 'Peta Sebaran Pendaftar - PPDB Online')

@section('styles')
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
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Peta Sebaran Pendaftar</h5>
                </div>
                <div class="card-body">
                    <!-- Filter Controls -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-select" id="filterJurusan">
                                <option value="">Semua Jurusan</option>
                                <option value="PPLG">PPLG</option>
                                <option value="DKV">DKV</option>
                                <option value="AKUNTANSI">Akuntansi</option>
                                <option value="ANIMASI">Animasi</option>
                                <option value="BDP">BDP</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="DRAFT">Draft</option>
                                <option value="SUBMITTED">Menunggu Verifikasi</option>
                                <option value="VERIFIED_ADM">Terverifikasi</option>
                                <option value="PAID">Terbayar</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary" onclick="updateMap()">
                                <i class="fas fa-sync me-1"></i>Update Peta
                            </button>
                        </div>
                        <div class="col-md-3 text-end">
                            <button class="btn btn-success" onclick="exportData()">
                                <i class="fas fa-download me-1"></i>Export Data
                            </button>
                        </div>
                    </div>

                    <!-- Map Container -->
                    <div id="map"></div>

                    <!-- Statistics Panel -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="info-panel text-center">
                                <h4 class="text-primary" id="totalPendaftar">0</h4>
                                <small class="text-muted">Total Pendaftar</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-panel text-center">
                                <h4 class="text-success" id="totalKecamatan">0</h4>
                                <small class="text-muted">Kecamatan</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-panel text-center">
                                <h4 class="text-info" id="totalKelurahan">0</h4>
                                <small class="text-muted">Kelurahan</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-panel text-center">
                                <h4 class="text-warning" id="radiusTerjauh">0</h4>
                                <small class="text-muted">Radius Terjauh (km)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Detail Sebaran per Wilayah</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="sebaranTable">
                            <thead>
                                <tr>
                                    <th>Kecamatan</th>
                                    <th>Kelurahan</th>
                                    <th>Jumlah Pendaftar</th>
                                    <th>PPLG</th>
                                    <th>DKV</th>
                                    <th>Akuntansi</th>
                                    <th>Animasi</th>
                                    <th>BDP</th>
                                    <th>Jarak Rata-rata</th>
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

// Initialize map
function initMap() {
    map = L.map('map').setView([-6.942100, 107.740300], 11);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Add school marker
    L.marker([-6.942100, 107.740300])
        .addTo(map)
        .bindPopup('<b>SMK Bakti Nusantara 666</b><br>Lokasi Sekolah')
        .openPopup();

    // Add legend
    addLegend();
    
    // Load initial data
    loadSebaranData();
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
    const filterJurusan = document.getElementById('filterJurusan').value;
    const filterStatus = document.getElementById('filterStatus').value;
    
    let url = '/admin/api/sebaran-data';
    const params = new URLSearchParams();
    if (filterJurusan) params.append('jurusan', filterJurusan);
    if (filterStatus) params.append('status', filterStatus);
    if (params.toString()) url += '?' + params.toString();
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            sebaranData = data;
            
            // Add sample data if no real data
            if (sebaranData.length === 0) {
                sebaranData = [
                    {
                        id: 1,
                        nama: 'Sample Pendaftar',
                        alamat: 'Jl. Sample No. 1',
                        latitude: -6.942100,
                        longitude: 107.740300,
                        jurusan: 'PPLG',
                        jurusan_kode: 'PPLG',
                        status: 'DRAFT',
                        kecamatan: 'Cileunyi',
                        kelurahan: 'Cimekar',
                        tanggal_daftar: '13 Nov 2024'
                    }
                ];
            }
            
            updateMapMarkers();
            updateStatistics();
            updateTable();
        })
        .catch(error => {
            console.error('Error loading sebaran data:', error);
            // Show error message
            document.getElementById('totalPendaftar').textContent = 'Error';
        });
}

function updateMapMarkers() {
    // Clear existing markers
    markers.forEach(marker => map.removeLayer(marker));
    markers = [];
    
    sebaranData.forEach(pendaftar => {
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
                <p class="mb-1"><strong>Jurusan:</strong> <span class="badge" style="background-color: ${jurusanColor}">${pendaftar.jurusan}</span></p>
                <p class="mb-1"><strong>Status:</strong> <span class="badge" style="background-color: ${statusColor}">${getStatusText(pendaftar.status)}</span></p>
                <p class="mb-1"><strong>Alamat:</strong> ${pendaftar.alamat}</p>
                <p class="mb-1"><strong>Wilayah:</strong> ${pendaftar.kelurahan}, ${pendaftar.kecamatan}</p>
                <p class="mb-0"><strong>Tgl Daftar:</strong> ${pendaftar.tanggal_daftar}</p>
                <hr class="my-2">
                <small class="text-muted">Koordinat: ${pendaftar.latitude.toFixed(6)}, ${pendaftar.longitude.toFixed(6)}</small>
            </div>
        `;
        
        marker.bindPopup(popupContent, {
            maxWidth: 300,
            className: 'custom-popup'
        });
        
        marker.addTo(map);
        markers.push(marker);
    });
}

function updateStatistics() {
    const totalPendaftar = sebaranData.length;
    const uniqueKecamatan = new Set(sebaranData.map(p => p.kecamatan)).size;
    const uniqueKelurahan = new Set(sebaranData.map(p => p.kelurahan)).size;
    
    // Calculate farthest distance from school
    const schoolLat = -6.942100;
    const schoolLng = 107.740300;
    let maxDistance = 0;
    
    sebaranData.forEach(p => {
        const distance = calculateDistance(schoolLat, schoolLng, p.latitude, p.longitude);
        if (distance > maxDistance) maxDistance = distance;
    });
    
    document.getElementById('totalPendaftar').textContent = totalPendaftar;
    document.getElementById('totalKecamatan').textContent = uniqueKecamatan;
    document.getElementById('totalKelurahan').textContent = uniqueKelurahan;
    document.getElementById('radiusTerjauh').textContent = maxDistance.toFixed(1);
}

function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Radius of the Earth in kilometers
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

function updateTable() {
    const tbody = document.getElementById('sebaranTableBody');
    tbody.innerHTML = '';
    
    // Group by kecamatan/kelurahan
    const grouped = {};
    sebaranData.forEach(p => {
        const key = `${p.kecamatan}-${p.kelurahan}`;
        if (!grouped[key]) {
            grouped[key] = {
                kecamatan: p.kecamatan,
                kelurahan: p.kelurahan,
                pendaftar: [],
                jurusanCount: {'PPLG': 0, 'DKV': 0, 'AKUNTANSI': 0, 'ANIMASI': 0, 'BDP': 0}
            };
        }
        grouped[key].pendaftar.push(p);
        if (grouped[key].jurusanCount.hasOwnProperty(p.jurusan_kode)) {
            grouped[key].jurusanCount[p.jurusan_kode]++;
        }
    });
    
    Object.values(grouped).forEach(wilayah => {
        const schoolLat = -6.942100;
        const schoolLng = 107.740300;
        const avgDistance = wilayah.pendaftar.reduce((sum, p) => {
            return sum + calculateDistance(schoolLat, schoolLng, p.latitude, p.longitude);
        }, 0) / wilayah.pendaftar.length;
        
        const row = `
            <tr>
                <td>${wilayah.kecamatan}</td>
                <td>${wilayah.kelurahan}</td>
                <td><span class="badge bg-primary">${wilayah.pendaftar.length}</span></td>
                <td>${wilayah.jurusanCount.PPLG}</td>
                <td>${wilayah.jurusanCount.DKV}</td>
                <td>${wilayah.jurusanCount.AKUNTANSI}</td>
                <td>${wilayah.jurusanCount.ANIMASI}</td>
                <td>${wilayah.jurusanCount.BDP}</td>
                <td>${avgDistance.toFixed(1)} km</td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

function updateMap() {
    updateMapMarkers();
    updateStatistics();
    updateTable();
}

function exportData() {
    // Implement export functionality
    alert('Export data functionality will be implemented');
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    initMap();
});
</script>
@endsection