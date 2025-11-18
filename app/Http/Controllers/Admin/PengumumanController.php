<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::first();
        
        // Statistik hasil seleksi
        $lulus = Pendaftar::where('status_berkas', 'VERIFIED')
            ->where('status_data', 'VERIFIED')
            ->where('status_pembayaran', 'LUNAS')
            ->count();
            
        $tidakLulus = Pendaftar::where(function($q) {
            $q->where('status_berkas', 'REJECTED')
              ->orWhere('status_data', 'REJECTED')
              ->orWhere('status_pembayaran', 'DITOLAK');
        })->count();
        
        $menunggu = Pendaftar::where('status', '!=', 'DRAFT')
            ->where('status_berkas', '!=', 'REJECTED')
            ->where('status_data', '!=', 'REJECTED')
            ->where('status_pembayaran', '!=', 'DITOLAK')
            ->where(function($q) {
                $q->where('status_berkas', 'PENDING')
                  ->orWhere('status_data', 'PENDING')
                  ->orWhere('status_pembayaran', 'PENDING');
            })->count();
        
        return view('admin.pengumuman', compact('pengumuman', 'lulus', 'tidakLulus', 'menunggu'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pengumuman' => 'required|date',
            'jam_pengumuman' => 'required',
            'status' => 'required|in:AKTIF,NONAKTIF'
        ]);
        
        Pengumuman::updateOrCreate(
            ['id' => 1],
            [
                'tanggal_pengumuman' => $request->tanggal_pengumuman,
                'jam_pengumuman' => $request->jam_pengumuman,
                'status' => $request->status,
                'updated_by' => auth()->id()
            ]
        );
        
        return response()->json(['success' => true, 'message' => 'Pengumuman berhasil disimpan']);
    }
}