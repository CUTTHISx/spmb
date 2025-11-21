<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\Gelombang;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $jurusan = Jurusan::all();
        $gelombang = Gelombang::all();
        
        $query = Pendaftar::with(['user', 'jurusan', 'gelombang']);
        
        if ($request->jurusan) $query->where('jurusan_id', $request->jurusan);
        if ($request->gelombang) $query->where('gelombang_id', $request->gelombang);
        if ($request->status) $query->where('status', $request->status);
        
        $pendaftar = $query->limit(100)->get();
        
        $statistics = [
            'total' => Pendaftar::count(),
            'verified' => Pendaftar::where('status', 'VERIFIED_ADM')->count(),
            'submitted' => Pendaftar::where('status', 'SUBMITTED')->count(),
            'paid' => 0,
            'total_payment' => 0,
        ];
        
        return view('admin.laporan', compact('jurusan', 'gelombang', 'pendaftar', 'statistics'));
    }

    public function laporanData(Request $request)
    {
        try {
            $statistics = [
                'total' => Pendaftar::count(),
                'verified' => Pendaftar::where('status', 'VERIFIED_ADM')->count(),
                'submitted' => Pendaftar::where('status', 'SUBMITTED')->count(),
                'paid' => 0,
                'total_payment' => 0,
            ];
            
            $data = Pendaftar::with(['user', 'jurusan', 'gelombang'])
                ->limit(50)
                ->get()
                ->map(function($p) {
                    return [
                        'nama' => $p->user->name ?? '-',
                        'email' => $p->user->email ?? '-',
                        'jurusan' => $p->jurusan->nama ?? '-',
                        'gelombang' => $p->gelombang->nama ?? '-',
                        'status' => $p->status,
                        'tanggal_daftar' => $p->created_at->format('d M Y'),
                    ];
                });
            
            return response()->json([
                'data' => $data,
                'statistics' => $statistics
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal memuat data: ' . $e->getMessage(),
                'data' => [],
                'statistics' => ['total' => 0, 'verified' => 0, 'submitted' => 0, 'paid' => 0, 'total_payment' => 0]
            ], 500);
        }
    }

    public function exportExcel(Request $request)
    {
        $query = Pendaftar::with(['user', 'dataSiswa', 'dataOrtu', 'asalSekolah', 'jurusan', 'gelombang', 'pembayaran']);
        
        // Apply filters
        if ($request->jurusan) {
            $query->where('jurusan_id', $request->jurusan);
        }
        if ($request->gelombang) {
            $query->where('gelombang_id', $request->gelombang);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->periode) {
            switch ($request->periode) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                    break;
                case 'custom':
                    if ($request->start_date && $request->end_date) {
                        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
                    }
                    break;
            }
        }
        
        $data = $query->get();
        
        $csv = "No,No Pendaftaran,Nama Lengkap,Email,NIK,NISN,Jenis Kelamin,Tempat Lahir,Tanggal Lahir,Alamat,Wilayah,Nama Ayah,Pekerjaan Ayah,HP Ayah,Nama Ibu,Pekerjaan Ibu,HP Ibu,Asal Sekolah,Jurusan,Gelombang,Status,Pembayaran,Tanggal Daftar\n";
        
        foreach ($data as $index => $p) {
            $csv .= ($index + 1) . ',"';
            $csv .= ($p->no_pendaftaran ?: '-') . '","';
            $csv .= ($p->dataSiswa->nama ?? $p->user->nama ?? '-') . '","';
            $csv .= ($p->user->email ?? '-') . '","';
            $csv .= ($p->dataSiswa->nik ?? '-') . '","';
            $csv .= ($p->dataSiswa->nisn ?? '-') . '","';
            $csv .= ($p->dataSiswa->jk ?? '-') . '","';
            $csv .= ($p->dataSiswa->tmp_lahir ?? '-') . '","';
            $csv .= ($p->dataSiswa->tgl_lahir ?? '-') . '","';
            $csv .= ($p->dataSiswa->alamat ?? '-') . '","';
            $csv .= ($p->dataSiswa->wilayah->nama ?? '-') . '","';
            $csv .= ($p->dataOrtu->nama_ayah ?? '-') . '","';
            $csv .= ($p->dataOrtu->pekerjaan_ayah ?? '-') . '","';
            $csv .= ($p->dataOrtu->hp_ayah ?? '-') . '","';
            $csv .= ($p->dataOrtu->nama_ibu ?? '-') . '","';
            $csv .= ($p->dataOrtu->pekerjaan_ibu ?? '-') . '","';
            $csv .= ($p->dataOrtu->hp_ibu ?? '-') . '","';
            $csv .= ($p->asalSekolah->nama_sekolah ?? '-') . '","';
            $csv .= ($p->jurusan->nama ?? '-') . '","';
            $csv .= ($p->gelombang->nama ?? '-') . '","';
            $csv .= $this->getStatusText($p->status) . '","';
            $csv .= ($p->pembayaran ? 'Rp ' . number_format($p->pembayaran->nominal, 0, ',', '.') : '-') . '","';
            $csv .= $p->created_at->format('d/m/Y H:i') . "\"\n";
        }
        
        $filename = 'laporan_ppdb_' . date('Y-m-d_H-i-s') . '.csv';
        
        return response($csv)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function exportPDF(Request $request)
    {
        $query = Pendaftar::with(['user', 'dataSiswa', 'dataOrtu', 'asalSekolah', 'jurusan', 'gelombang', 'pembayaran']);
        
        // Apply filters
        if ($request->jurusan) {
            $query->where('jurusan_id', $request->jurusan);
        }
        if ($request->gelombang) {
            $query->where('gelombang_id', $request->gelombang);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->periode) {
            switch ($request->periode) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
                case 'custom':
                    if ($request->start_date && $request->end_date) {
                        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
                    }
                    break;
            }
        }
        
        $data = $query->get();
        
        $statistics = [
            'total' => $data->count(),
            'verified' => $data->where('status', 'VERIFIED_ADM')->count(),
            'paid' => $data->where('status', 'PAID')->count(),
            'total_payment' => $data->where('status', 'PAID')
                                   ->sum(function($p) {
                                       return $p->pembayaran ? $p->pembayaran->nominal : 0;
                                   })
        ];
        
        $status_texts = [
            'DRAFT' => 'Draft',
            'SUBMITTED' => 'Submitted',
            'VERIFIED_ADM' => 'Terverifikasi',
            'REJECTED' => 'Ditolak',
            'PAID' => 'Terbayar'
        ];
        
        // Get filter labels
        $filter_jurusan = $request->jurusan ? Jurusan::find($request->jurusan)->nama : 'Semua Jurusan';
        $filter_gelombang = $request->gelombang ? Gelombang::find($request->gelombang)->nama : 'Semua Gelombang';
        
        $periode = 'Semua Data';
        if ($request->periode) {
            switch ($request->periode) {
                case 'today': $periode = 'Hari Ini'; break;
                case 'week': $periode = 'Minggu Ini'; break;
                case 'month': $periode = 'Bulan Ini'; break;
                case 'custom': $periode = $request->start_date . ' s/d ' . $request->end_date; break;
            }
        }
        
        $html = view('exports.pdf.laporan-ppdb', compact('data', 'statistics', 'status_texts', 'filter_jurusan', 'filter_gelombang', 'periode'))->render();
        
        $filename = 'laporan_ppdb_' . date('Y-m-d_H-i-s') . '.html';
        
        return response($html)
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
    
    private function getStatusText($status)
    {
        $texts = [
            'DRAFT' => 'Draft',
            'SUBMITTED' => 'Submitted', 
            'VERIFIED_ADM' => 'Terverifikasi',
            'REJECTED' => 'Ditolak',
            'PAID' => 'Terbayar'
        ];
        return $texts[$status] ?? 'Unknown';
    }
}