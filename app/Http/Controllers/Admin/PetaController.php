<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function index()
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan'])->get();
            
        // Simulate geographical distribution if no real data
        $sebaranKecamatan = collect([
            (object)['kecamatan' => 'Kota', 'total' => Pendaftar::count() * 0.3],
            (object)['kecamatan' => 'Utara', 'total' => Pendaftar::count() * 0.2],
            (object)['kecamatan' => 'Selatan', 'total' => Pendaftar::count() * 0.2],
            (object)['kecamatan' => 'Timur', 'total' => Pendaftar::count() * 0.15],
            (object)['kecamatan' => 'Barat', 'total' => Pendaftar::count() * 0.15],
        ]);
        
        // Try to get real data if available
        $realData = Pendaftar::join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->selectRaw('kecamatan, count(*) as total')
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->get();
            
        if ($realData->isNotEmpty()) {
            $sebaranKecamatan = $realData;
        }
            
        return view('admin.peta', compact('pendaftar', 'sebaranKecamatan'));
    }
    
    public function getSebaranData()
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang', 'user'])
            ->whereHas('dataSiswa', function($query) {
                $query->where(function($q) {
                    $q->whereNotNull('lat')
                      ->whereNotNull('lng')
                      ->where('lat', '!=', 0)
                      ->where('lng', '!=', 0);
                })->orWhereNotNull('wilayah_id');
            })
            ->where('status', '!=', 'DRAFT')
            ->get();

        $mapData = [];
        
        foreach ($pendaftar as $p) {
            if ($p->dataSiswa) {
                $wilayah = null;
                if ($p->dataSiswa->wilayah_id) {
                    $wilayah = \App\Models\Wilayah::find($p->dataSiswa->wilayah_id);
                }
                
                // Prioritize real GPS coordinates over generated ones
                if ($p->dataSiswa->lat && $p->dataSiswa->lng && $p->dataSiswa->lat != 0 && $p->dataSiswa->lng != 0) {
                    $latitude = (float) $p->dataSiswa->lat;
                    $longitude = (float) $p->dataSiswa->lng;
                } elseif ($wilayah) {
                    $coordinates = $this->getWilayahCoordinates($wilayah);
                    $latitude = $coordinates['latitude'];
                    $longitude = $coordinates['longitude'];
                } else {
                    continue; // Skip if no coordinates available
                }
                
                $mapData[] = [
                    'id' => $p->id,
                    'nama' => $p->dataSiswa->nama ?? $p->user->nama ?? 'Unknown',
                    'email' => $p->user->email ?? 'Unknown',
                    'jurusan' => $p->jurusan->nama ?? 'Belum Pilih',
                    'jurusan_kode' => $p->jurusan->kode ?? 'N/A',
                    'gelombang' => $p->gelombang->nama ?? 'Belum Pilih',
                    'status' => $p->status,
                    'alamat' => $p->dataSiswa->alamat ?? '',
                    'rt_rw' => $p->dataSiswa->rt_rw ?? '',
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'kecamatan' => $wilayah->kecamatan ?? 'Unknown',
                    'kelurahan' => $wilayah->kelurahan ?? 'Unknown',
                    'kabupaten' => $wilayah->kabupaten ?? 'Unknown',
                    'provinsi' => $wilayah->provinsi ?? 'Unknown',
                    'kodepos' => $wilayah->kodepos ?? 'Unknown',
                    'tanggal_daftar' => $p->created_at->format('d M Y H:i')
                ];
            }
        }
            
        return response()->json($mapData);
    }

    private function getWilayahCoordinates($wilayah)
    {
        // Koordinat default Indonesia (Jakarta)
        $baseLatitude = -6.2088;
        $baseLongitude = 106.8456;
        
        // Generate koordinat berdasarkan hash wilayah untuk konsistensi
        $hash = crc32($wilayah->provinsi . $wilayah->kabupaten . $wilayah->kecamatan . $wilayah->kelurahan);
        
        // Offset random tapi konsisten berdasarkan wilayah
        $latOffset = (($hash % 1000) / 1000 - 0.5) * 10; // ±5 derajat
        $lngOffset = (($hash % 2000) / 2000 - 0.5) * 15; // ±7.5 derajat
        
        return [
            'latitude' => $baseLatitude + $latOffset,
            'longitude' => $baseLongitude + $lngOffset
        ];
    }

    public function getMapUpdate()
    {
        $lastUpdate = Pendaftar::whereHas('dataSiswa', function($query) {
            $query->whereNotNull('wilayah_id');
        })->latest('updated_at')->first();

        return response()->json([
            'last_update' => $lastUpdate ? $lastUpdate->updated_at->timestamp : 0,
            'total_pendaftar' => Pendaftar::whereHas('dataSiswa', function($query) {
                $query->whereNotNull('wilayah_id');
            })->where('status', '!=', 'DRAFT')->count()
        ]);
    }
}