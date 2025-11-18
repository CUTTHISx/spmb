<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\PendaftarPembayaran;
use App\Models\Gelombang;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));
        
        $gelombangs = Gelombang::all();
        $jurusans = Jurusan::all();
        
        // Rekap per gelombang
        $rekapGelombang = PendaftarPembayaran::select(
                'gelombang.nama as nama_gelombang',
                DB::raw('COUNT(*) as jumlah_pembayaran'),
                DB::raw('SUM(pendaftar_pembayaran.nominal) as total_pemasukan')
            )
            ->join('pendaftar', 'pendaftar_pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
            ->where('pendaftar_pembayaran.status_verifikasi', 'VERIFIED')
            ->whereBetween('pendaftar_pembayaran.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('gelombang.id', 'gelombang.nama')
            ->get();
            
        // Rekap per jurusan
        $rekapJurusan = PendaftarPembayaran::select(
                'jurusan.nama as nama_jurusan',
                DB::raw('COUNT(*) as jumlah_pembayaran'),
                DB::raw('SUM(pendaftar_pembayaran.nominal) as total_pemasukan')
            )
            ->join('pendaftar', 'pendaftar_pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->where('pendaftar_pembayaran.status_verifikasi', 'VERIFIED')
            ->whereBetween('pendaftar_pembayaran.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('jurusan.id', 'jurusan.nama')
            ->get();
        
        return view('keuangan.rekap', compact('gelombangs', 'jurusans', 'rekapGelombang', 'rekapJurusan'));
    }
    
    public function exportExcel(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));
        
        $filename = 'rekap_keuangan_' . $startDate . '_to_' . $endDate . '.csv';
        
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Header
        fputcsv($output, ['REKAP KEUANGAN PPDB ONLINE']);
        fputcsv($output, ['Periode: ' . date('d/m/Y', strtotime($startDate)) . ' - ' . date('d/m/Y', strtotime($endDate))]);
        fputcsv($output, ['Tanggal Export: ' . date('d/m/Y H:i')]);
        fputcsv($output, []);
        
        // Rekap Gelombang
        fputcsv($output, ['REKAP PER GELOMBANG']);
        fputcsv($output, ['Gelombang', 'Jumlah Pembayaran', 'Total Pemasukan']);
        
        $rekapGelombang = PendaftarPembayaran::select(
                'gelombang.nama as nama_gelombang',
                DB::raw('COUNT(*) as jumlah_pembayaran'),
                DB::raw('SUM(pendaftar_pembayaran.nominal) as total_pemasukan')
            )
            ->join('pendaftar', 'pendaftar_pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
            ->where('pendaftar_pembayaran.status_verifikasi', 'VERIFIED')
            ->whereBetween('pendaftar_pembayaran.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('gelombang.id', 'gelombang.nama')
            ->get();
            
        foreach ($rekapGelombang as $rekap) {
            fputcsv($output, [
                $rekap->nama_gelombang,
                $rekap->jumlah_pembayaran,
                'Rp ' . number_format($rekap->total_pemasukan, 0, ',', '.')
            ]);
        }
        
        fputcsv($output, []);
        
        // Rekap Jurusan
        fputcsv($output, ['REKAP PER JURUSAN']);
        fputcsv($output, ['Jurusan', 'Jumlah Pembayaran', 'Total Pemasukan']);
        
        $rekapJurusan = PendaftarPembayaran::select(
                'jurusan.nama as nama_jurusan',
                DB::raw('COUNT(*) as jumlah_pembayaran'),
                DB::raw('SUM(pendaftar_pembayaran.nominal) as total_pemasukan')
            )
            ->join('pendaftar', 'pendaftar_pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->where('pendaftar_pembayaran.status_verifikasi', 'VERIFIED')
            ->whereBetween('pendaftar_pembayaran.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('jurusan.id', 'jurusan.nama')
            ->get();
            
        foreach ($rekapJurusan as $rekap) {
            fputcsv($output, [
                $rekap->nama_jurusan,
                $rekap->jumlah_pembayaran,
                'Rp ' . number_format($rekap->total_pemasukan, 0, ',', '.')
            ]);
        }
        
        fputcsv($output, []);
        
        // Total
        $totalPemasukan = PendaftarPembayaran::where('status_verifikasi', 'VERIFIED')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('nominal');
        fputcsv($output, ['TOTAL KESELURUHAN', '', 'Rp ' . number_format($totalPemasukan, 0, ',', '.')]);
        
        fclose($output);
        exit;
    }
    
    public function exportPDF(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));
        
        // Get data
        $rekapGelombang = PendaftarPembayaran::select(
                'gelombang.nama as nama_gelombang',
                DB::raw('COUNT(*) as jumlah_pembayaran'),
                DB::raw('SUM(pendaftar_pembayaran.nominal) as total_pemasukan')
            )
            ->join('pendaftar', 'pendaftar_pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
            ->where('pendaftar_pembayaran.status_verifikasi', 'VERIFIED')
            ->whereBetween('pendaftar_pembayaran.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('gelombang.id', 'gelombang.nama')
            ->get();
            
        $rekapJurusan = PendaftarPembayaran::select(
                'jurusan.nama as nama_jurusan',
                DB::raw('COUNT(*) as jumlah_pembayaran'),
                DB::raw('SUM(pendaftar_pembayaran.nominal) as total_pemasukan')
            )
            ->join('pendaftar', 'pendaftar_pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->where('pendaftar_pembayaran.status_verifikasi', 'VERIFIED')
            ->whereBetween('pendaftar_pembayaran.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('jurusan.id', 'jurusan.nama')
            ->get();
            
        $totalPemasukan = PendaftarPembayaran::where('status_verifikasi', 'VERIFIED')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('nominal');
        $totalPembayaran = PendaftarPembayaran::where('status_verifikasi', 'VERIFIED')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->count();
        
        $data = compact('rekapGelombang', 'rekapJurusan', 'totalPemasukan', 'totalPembayaran', 'startDate', 'endDate');
        
        $pdf = Pdf::loadView('exports.pdf.rekap-keuangan', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('rekap_keuangan_' . $startDate . '_to_' . $endDate . '.pdf');
    }
}