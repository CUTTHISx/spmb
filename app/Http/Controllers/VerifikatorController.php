<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikatorController extends Controller
{
    public function dashboard()
    {
        $pendingVerification = Pendaftar::where('status', '!=', 'DRAFT')
            ->where(function($q) {
                $q->where('status_berkas', 'PENDING')
                  ->orWhere('status_data', 'PENDING');
            })
            ->count();
        
        $verifiedAll = Pendaftar::where('status_berkas', 'VERIFIED')
            ->where('status_data', 'VERIFIED')
            ->count();
            
        $rejected = Pendaftar::where('status_berkas', 'REJECTED')
            ->orWhere('status_data', 'REJECTED')
            ->count();
        
        return view('dashboard.verifikator', compact('pendingVerification', 'verifiedAll', 'rejected'));
    }
    
    public function verifikasi()
    {
        $pendaftar = Pendaftar::with(['user', 'jurusan', 'dataSiswa', 'dataOrtu', 'asalSekolah', 'berkas'])
            ->where('status', '!=', 'DRAFT')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('verifikator.verifikasi', compact('pendaftar'));
    }
    
    public function detail($id)
    {
        $pendaftar = Pendaftar::with(['user', 'jurusan', 'dataSiswa', 'dataOrtu', 'asalSekolah', 'berkas'])
            ->findOrFail($id);
            
        return view('verifikator.detail', compact('pendaftar'));
    }
    
    public function updateBerkasStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:VERIFIED,REJECTED,REVISION',
            'catatan' => 'required|string|min:5'
        ]);
        
        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->update([
            'status_berkas' => $request->status,
            'user_verifikasi_berkas' => Auth::id(),
            'tgl_verifikasi_berkas' => now(),
            'catatan_verifikasi' => $request->catatan
        ]);
        
        // Log verification activity
        \App\Models\LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Verifikasi Berkas',
            'deskripsi' => "Verifikasi berkas pendaftar {$pendaftar->user->name} - Status: {$request->status}",
            'ip_address' => request()->ip()
        ]);
        
        return response()->json(['success' => true, 'message' => 'Verifikasi berkas berhasil disimpan']);
    }
    
    public function updateDataStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:VERIFIED,REJECTED,REVISION',
            'catatan' => 'required|string|min:5'
        ]);
        
        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->update([
            'status_data' => $request->status,
            'user_verifikasi_data' => Auth::id(),
            'tgl_verifikasi_data' => now(),
            'catatan_verifikasi' => $request->catatan
        ]);
        
        // Auto update main status if both berkas and data are verified
        if ($pendaftar->status_berkas == 'VERIFIED' && $pendaftar->status_data == 'VERIFIED') {
            $pendaftar->update(['status' => 'VERIFIED_ADM']);
        } elseif ($pendaftar->status_berkas == 'REJECTED' || $pendaftar->status_data == 'REJECTED') {
            $pendaftar->update(['status' => 'REJECTED']);
        } elseif ($pendaftar->status_berkas == 'REVISION' || $pendaftar->status_data == 'REVISION') {
            $pendaftar->update(['status' => 'REVISION']);
        }
        
        // Log verification activity
        \App\Models\LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Verifikasi Data',
            'deskripsi' => "Verifikasi data pendaftar {$pendaftar->user->name} - Status: {$request->status}",
            'ip_address' => request()->ip()
        ]);
        
        return response()->json(['success' => true, 'message' => 'Verifikasi data berhasil disimpan']);
    }
}