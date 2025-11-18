<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\PendaftarPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function dashboard()
    {
        // Hitung berdasarkan status_verifikasi di tabel pembayaran
        $pendingPayment = PendaftarPembayaran::where('status_verifikasi', 'PENDING')->count();
        $verifiedPayment = PendaftarPembayaran::where('status_verifikasi', 'VERIFIED')->count();
        $rejectedPayment = PendaftarPembayaran::where('status_verifikasi', 'REJECTED')->count();
        
        // Total pemasukan dari pembayaran terverifikasi
        $totalPemasukan = PendaftarPembayaran::where('status_verifikasi', 'VERIFIED')->sum('nominal');
        
        // Recent payments for table
        $recentPayments = Pendaftar::with(['user', 'dataSiswa', 'pembayaran'])
            ->whereHas('pembayaran')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard.keuangan', compact('pendingPayment', 'verifiedPayment', 'rejectedPayment', 'totalPemasukan', 'recentPayments'));
    }
    
    public function verifikasi()
    {
        $pendaftar = Pendaftar::with(['user', 'jurusan', 'pembayaran', 'dataSiswa'])
            ->where('status', '!=', 'DRAFT')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Statistics - using existing columns
        $menungguVerifikasi = Pendaftar::whereHas('pembayaran', function($q) {
            $q->where('status_verifikasi', 'PENDING');
        })->count();
        $terbayar = Pendaftar::whereHas('pembayaran', function($q) {
            $q->where('status_verifikasi', 'VERIFIED');
        })->count();
        $ditolak = Pendaftar::whereHas('pembayaran', function($q) {
            $q->where('status_verifikasi', 'REJECTED');
        })->count();
        $belumBayar = Pendaftar::whereDoesntHave('pembayaran')->count();
            
        return view('keuangan.verifikasi', compact('pendaftar', 'menungguVerifikasi', 'terbayar', 'ditolak', 'belumBayar'));
    }
    
    public function updatePaymentStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:LUNAS,DITOLAK',
                'catatan' => 'nullable|string'
            ]);
            
            $pendaftar = Pendaftar::findOrFail($id);
            
            // Update status di tabel pembayaran dengan nilai yang sesuai
            if ($pendaftar->pembayaran) {
                $pembayaranStatus = $request->status == 'LUNAS' ? 'VERIFIED' : 'REJECTED';
                $pendaftar->pembayaran->update([
                    'status_verifikasi' => $pembayaranStatus,
                    'catatan' => $request->catatan
                ]);
            }
            
            // Update status_payment di tabel pendaftar (using existing column)
            $pendaftar->update([
                'status_payment' => $request->status == 'LUNAS' ? 'VERIFIED' : 'REJECTED',
                'user_verifikasi_payment' => Auth::id(),
                'tgl_verifikasi_payment' => now()
            ]);
            
            // Log activity
            try {
                \App\Models\LogAktivitas::create([
                    'user_id' => Auth::id(),
                    'aktivitas' => 'Verifikasi Pembayaran',
                    'deskripsi' => "Verifikasi pembayaran pendaftar {$pendaftar->user->name} - Status: {$request->status}",
                    'ip_address' => request()->ip()
                ]);
            } catch (\Exception $e) {
                // Log error but don't fail the verification
            }
            
            return response()->json(['success' => true, 'message' => 'Verifikasi pembayaran berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
    
    public function getPaymentProof($id)
    {
        $pendaftar = Pendaftar::with('pembayaran')->findOrFail($id);
        
        if ($pendaftar->pembayaran && $pendaftar->pembayaran->bukti_pembayaran) {
            // Remove 'uploads/' prefix if it exists in the stored path
            $filePath = str_replace('uploads/', '', $pendaftar->pembayaran->bukti_pembayaran);
            $buktiUrl = asset('uploads/' . $filePath);
            
            return response()->json([
                'success' => true,
                'bukti_url' => $buktiUrl
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Bukti pembayaran tidak ditemukan'
        ]);
    }
}