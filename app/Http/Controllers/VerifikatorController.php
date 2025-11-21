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
            ->where(function($query) {
                $query->where('status_berkas', 'PENDING')
                      ->orWhere('status_data', 'PENDING')
                      ->orWhere('status_berkas', 'REVISION')
                      ->orWhere('status_data', 'REVISION')
                      ->orWhereNull('status_berkas')
                      ->orWhereNull('status_data');
            })
            ->count();
        
        $needsRevision = Pendaftar::where(function($query) {
                $query->where('status_berkas', 'REVISION')
                      ->orWhere('status_data', 'REVISION');
            })
            ->count();
        
        $verifiedAll = Pendaftar::where('status_berkas', 'VERIFIED')
            ->where('status_data', 'VERIFIED')
            ->count();
            
        $rejected = Pendaftar::where('status_berkas', 'REJECTED')
            ->orWhere('status_data', 'REJECTED')
            ->count();
            
        $totalPendaftar = Pendaftar::whereIn('status', ['SUBMITTED', 'VERIFIED_ADM', 'REJECTED_ADM'])->count();
        
        return view('dashboard.verifikator', compact('pendingVerification', 'needsRevision', 'verifiedAll', 'rejected', 'totalPendaftar'));
    }
    
    public function verifikasi()
    {
        $pendaftar = Pendaftar::with(['user', 'jurusan', 'dataSiswa', 'dataOrtu', 'asalSekolah', 'berkas'])
            ->whereIn('status', ['SUBMITTED', 'VERIFIED_ADM', 'REJECTED_ADM'])
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
            // Set default jenis if not provided
            if (!$request->has('jenis')) {
                $request->merge(['jenis' => 'both']);
            }
            
            $request->validate([
                'jenis' => 'required|in:berkas,data,both',
                'status' => 'required|in:VERIFIED,REJECTED',
                'catatan' => 'required|string|min:5'
            ]);
            
            $pendaftar = Pendaftar::findOrFail($id);
            $updateData = [];
            
            // Update berdasarkan jenis verifikasi
            if ($request->jenis == 'berkas' || $request->jenis == 'both') {
                $updateData['status_berkas'] = $request->status;
                $updateData['user_verifikasi_berkas'] = Auth::id();
                $updateData['tgl_verifikasi_berkas'] = now();
            }
            
            if ($request->jenis == 'data' || $request->jenis == 'both') {
                $updateData['status_data'] = $request->status;
                $updateData['user_verifikasi_data'] = Auth::id();
                $updateData['tgl_verifikasi_data'] = now();
            }
            
            $updateData['catatan_verifikasi'] = $request->catatan;
            $pendaftar->update($updateData);
            
            // Update main status berdasarkan kombinasi status berkas dan data
            $statusBerkas = $pendaftar->fresh()->status_berkas;
            $statusData = $pendaftar->fresh()->status_data;
            
            if ($statusBerkas == 'VERIFIED' && $statusData == 'VERIFIED') {
                $pendaftar->update(['status' => 'VERIFIED_ADM']);
            } elseif ($statusBerkas == 'REJECTED' || $statusData == 'REJECTED') {
                // Tetap SUBMITTED agar pendaftar bisa upload ulang berkas
                $pendaftar->update(['status' => 'SUBMITTED']);
            }
            
            return response()->json([
                'success' => true, 
                'message' => 'Verifikasi berhasil disimpan',
                'status' => $request->status,
                'jenis' => $request->jenis
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