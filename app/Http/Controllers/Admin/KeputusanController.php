<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeputusanController extends Controller
{
    public function index()
    {
        // Lightweight stats only
        $stats = [
            'total' => Pendaftar::count(),
            'siap_keputusan' => Pendaftar::whereNull('hasil_keputusan')
                ->where('status_berkas', 'VERIFIED')
                ->where('status_data', 'VERIFIED')
                ->whereHas('pembayaran', function($q) {
                    $q->where('status_verifikasi', 'VERIFIED');
                })->count(),
            'lulus' => Pendaftar::where('hasil_keputusan', 'LULUS')->count(),
            'tidak_lulus' => Pendaftar::where('hasil_keputusan', 'TIDAK_LULUS')->count(),
            'cadangan' => Pendaftar::where('hasil_keputusan', 'CADANGAN')->count(),
        ];

        // Get pendaftar data for table
        $pendaftar = Pendaftar::with(['user', 'dataSiswa', 'jurusan', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return view('admin.keputusan.index', compact('stats', 'pendaftar'));
    }

    public function detail($id)
    {
        $pendaftar = Pendaftar::with(['dataSiswa.wilayah', 'dataOrtu', 'asalSekolah', 'jurusan', 'pembayaran', 'berkas'])
            ->findOrFail($id);

        $wilayah = $pendaftar->dataSiswa->wilayah;
        $wilayahText = $wilayah ? "{$wilayah->kelurahan}, {$wilayah->kecamatan}, {$wilayah->kabupaten}" : '-';

        return response()->json([
            'success' => true,
            'data' => [
                'no_pendaftaran' => $pendaftar->no_pendaftaran,
                'nama' => $pendaftar->dataSiswa->nama ?? '-',
                'nisn' => $pendaftar->dataSiswa->nisn ?? '-',
                'nik' => $pendaftar->dataSiswa->nik ?? '-',
                'jk' => $pendaftar->dataSiswa->jk ?? '-',
                'tmp_lahir' => $pendaftar->dataSiswa->tmp_lahir ?? '-',
                'tgl_lahir' => $pendaftar->dataSiswa->tgl_lahir ?? '-',
                'alamat' => $pendaftar->dataSiswa->alamat ?? '-',
                'wilayah' => $wilayahText,
                'jurusan' => $pendaftar->jurusan->nama ?? '-',
                'status' => $pendaftar->status,
                'tgl_daftar' => $pendaftar->created_at->format('d/m/Y H:i'),
                'nama_ayah' => $pendaftar->dataOrtu->nama_ayah ?? '-',
                'nama_ibu' => $pendaftar->dataOrtu->nama_ibu ?? '-',
                'hp_ayah' => $pendaftar->dataOrtu->hp_ayah ?? '-',
                'hp_ibu' => $pendaftar->dataOrtu->hp_ibu ?? '-',
                'asal_sekolah' => $pendaftar->asalSekolah->nama_sekolah ?? '-',
                'npsn' => $pendaftar->asalSekolah->npsn ?? '-',
                'nilai_rata' => $pendaftar->asalSekolah->nilai_rata ?? '-',
                'nominal_bayar' => $pendaftar->pembayaran->nominal ?? '-',
                'status_bayar' => $pendaftar->pembayaran->status_verifikasi ?? '-',
                'hasil_keputusan' => $pendaftar->hasil_keputusan,
                'tgl_keputusan' => $pendaftar->tgl_keputusan ? \Carbon\Carbon::parse($pendaftar->tgl_keputusan)->format('d/m/Y H:i') : null,
                'berkas' => $pendaftar->berkas->map(function($b) {
                    $jenis = $b->jenis;
                    if ($jenis === 'LAINNYA' && strpos($b->nama_file, 'foto') !== false) {
                        $jenis = 'FOTO';
                    }
                    return [
                        'jenis' => $jenis,
                        'nama_file' => $b->nama_file,
                        'status' => $b->status_verifikasi,
                        'url' => $b->url,
                        'ukuran_kb' => $b->ukuran_kb
                    ];
                })
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pendaftar_id' => 'required|exists:pendaftar,id',
            'hasil_keputusan' => 'required|in:LULUS,TIDAK_LULUS,CADANGAN',
            'catatan_keputusan' => 'nullable|string|max:500'
        ]);

        $pendaftar = Pendaftar::with(['user', 'dataSiswa', 'jurusan'])->findOrFail($request->pendaftar_id);
        
        $pendaftar->update([
            'hasil_keputusan' => $request->hasil_keputusan,
            'user_keputusan' => Auth::user()->name ?? Auth::user()->nama,
            'tgl_keputusan' => now(),
            'catatan_keputusan' => $request->catatan_keputusan
        ]);

        // Kirim email pengumuman di background
        dispatch(function() use ($pendaftar) {
            try {
                \Mail::to($pendaftar->user->email)->send(new \App\Mail\HasilKeputusanMail($pendaftar));
            } catch (\Exception $e) {
                \Log::error('Gagal kirim email keputusan: ' . $e->getMessage());
            }
        })->afterResponse();

        return response()->json([
            'success' => true,
            'message' => 'Keputusan berhasil disimpan. Email pengumuman sedang dikirim.'
        ]);
    }
}