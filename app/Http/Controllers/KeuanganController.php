<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function dashboard()
    {
        $pendingPayment = Pendaftar::where('status_payment', 'PENDING')
            ->where('status', '!=', 'DRAFT')
            ->count();
        
        $verifiedPayment = Pendaftar::where('status_payment', 'VERIFIED')->count();
        $rejectedPayment = Pendaftar::where('status_payment', 'REJECTED')->count();
        
        return view('dashboard.keuangan', compact('pendingPayment', 'verifiedPayment', 'rejectedPayment'));
    }
    
    public function verifikasi()
    {
        $pendaftar = Pendaftar::with(['user', 'jurusan', 'pembayaran'])
            ->where('status', '!=', 'DRAFT')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('keuangan.verifikasi', compact('pendaftar'));
    }
    
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:VERIFIED,REJECTED',
            'catatan' => 'nullable|string'
        ]);
        
        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->update([
            'status_payment' => $request->status,
            'user_verifikasi_payment' => Auth::id(),
            'tgl_verifikasi_payment' => now(),
            'catatan_verifikasi' => $request->catatan
        ]);
        
        return response()->json(['success' => true]);
    }
}