<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikatorController extends Controller
{
    public function dashboard()
    {
        $pendingVerification = Pendaftar::where('status', 'SUBMITTED')
            ->count();
        
        $verifiedAll = Pendaftar::where('status_berkas', 'VERIFIED')
            ->where('status_data', 'VERIFIED')
            ->count();
            
        $rejected = Pendaftar::where('status_berkas', 'REJECTED')
            ->orWhere('status_data', 'REJECTED')
            ->count();
            
        $totalPendaftar = Pendaftar::whereIn('status', ['SUBMITTED', 'ADM_PASS', 'ADM_REJECT'])->count();
        
        return view('dashboard.verifikator', compact('pendingVerification', 'verifiedAll', 'rejected', 'totalPendaftar'));
    }
    
    public function verifikasi()
    {
        $pendaftar = Pendaftar::with(['user', 'jurusan', 'dataSiswa', 'dataOrtu', 'asalSekolah', 'berkas'])
            ->where('status', 'SUBMITTED')
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
    
    public function updateVerifikasi(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:VERIFIED,REJECTED,REVISION',
                'catatan' => 'required|string|min:5'
            ]);
            
            $pendaftar = Pendaftar::findOrFail($id);
            $pendaftar->update([
                'status_berkas' => $request->status,
                'status_data' => $request->status,
                'user_verifikasi_berkas' => Auth::id(),
                'user_verifikasi_data' => Auth::id(),
                'tgl_verifikasi_berkas' => now(),
                'tgl_verifikasi_data' => now(),
                'catatan_verifikasi' => $request->catatan
            ]);
            
            // Update main status
            if ($request->status == 'VERIFIED') {
                $pendaftar->update(['status' => 'VERIFIED']);
            } elseif ($request->status == 'REJECTED') {
                $pendaftar->update(['status' => 'REJECTED']);
            }
            
            return response()->json([
                'success' => true, 
                'message' => 'Verifikasi berhasil disimpan',
                'status' => $request->status
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Data tidak valid: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}