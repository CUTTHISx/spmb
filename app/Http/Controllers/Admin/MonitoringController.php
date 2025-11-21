<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'dataOrtu', 'asalSekolah', 'jurusan', 'berkas', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        $stats = [
            'totalPendaftar' => Pendaftar::count(),
            'berkasLengkap' => Pendaftar::where('status', 'ADM_PASS')->count(),
            'menungguVerifikasi' => Pendaftar::where('status', 'SUBMITTED')->count(),
            'berkasKurang' => Pendaftar::where('status', 'DRAFT')->count(),
        ];
        
        return view('admin.monitoring', array_merge(compact('pendaftar'), $stats));
    }
    
    public function detail($id)
    {
        try {
            $pendaftar = Pendaftar::with(['dataSiswa.wilayah', 'dataOrtu', 'asalSekolah', 'jurusan', 'berkas', 'user', 'pembayaran'])
                ->findOrFail($id);
                
            return response()->json([
                'success' => true,
                'data' => [
                    'no_pendaftaran' => $pendaftar->no_pendaftaran ?? 'PPDB'.date('Y').str_pad($id, 4, '0', STR_PAD_LEFT),
                    'nama' => $pendaftar->dataSiswa->nama ?? $pendaftar->user->nama ?? 'N/A',
                    'nisn' => $pendaftar->dataSiswa->nisn ?? '-',
                    'nik' => $pendaftar->dataSiswa->nik ?? '-',
                    'jk' => $pendaftar->dataSiswa->jk ?? '-',
                    'tmp_lahir' => $pendaftar->dataSiswa->tmp_lahir ?? '-',
                    'tgl_lahir' => $pendaftar->dataSiswa->tgl_lahir ?? '-',
                    'alamat' => $pendaftar->dataSiswa->alamat ?? '-',
                    'wilayah' => $pendaftar->dataSiswa->wilayah->nama ?? '-',
                    'jurusan' => $pendaftar->jurusan->nama ?? 'Belum Pilih',
                    'status' => $pendaftar->status,
                    'tgl_daftar' => $pendaftar->created_at->format('d/m/Y H:i'),
                    'nama_ayah' => $pendaftar->dataOrtu->nama_ayah ?? '-',
                    'nama_ibu' => $pendaftar->dataOrtu->nama_ibu ?? '-',
                    'hp_ayah' => $pendaftar->dataOrtu->hp_ayah ?? '-',
                    'hp_ibu' => $pendaftar->dataOrtu->hp_ibu ?? '-',
                    'asal_sekolah' => $pendaftar->asalSekolah->nama_sekolah ?? '-',
                    'npsn' => $pendaftar->asalSekolah->npsn ?? '-',
                    'nilai_rata' => $pendaftar->asalSekolah->nilai_rata ?? '-',
                    'nominal_bayar' => $pendaftar->pembayaran->nominal ?? 0,
                    'status_bayar' => $pendaftar->pembayaran->status_verifikasi ?? 'BELUM_BAYAR',
                    'berkas' => $pendaftar->berkas->map(function($berkas) {
                        return [
                            'jenis' => $berkas->jenis,
                            'nama_file' => $berkas->nama_file,
                            'status' => $berkas->status_verifikasi,
                            'url' => $berkas->url,
                            'ukuran_kb' => $berkas->ukuran_kb
                        ];
                    })
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }
}