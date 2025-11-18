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
        $pendaftar = Pendaftar::with(['user', 'dataSiswa', 'jurusan', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'siap_keputusan' => $pendaftar->filter(function($p) {
                return !$p->hasil_keputusan && 
                       $p->status_berkas == 'VERIFIED' && 
                       $p->status_data == 'VERIFIED' && 
                       $p->pembayaran && 
                       $p->pembayaran->status_verifikasi == 'VERIFIED';
            })->count(),
            'lulus' => $pendaftar->where('hasil_keputusan', 'LULUS')->count(),
            'tidak_lulus' => $pendaftar->where('hasil_keputusan', 'TIDAK_LULUS')->count(),
            'cadangan' => $pendaftar->where('hasil_keputusan', 'CADANGAN')->count(),
        ];

        return view('admin.keputusan.index', compact('pendaftar', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pendaftar_id' => 'required|exists:pendaftar,id',
            'hasil_keputusan' => 'required|in:LULUS,TIDAK_LULUS,CADANGAN',
            'catatan_keputusan' => 'nullable|string|max:500'
        ]);

        $pendaftar = Pendaftar::findOrFail($request->pendaftar_id);
        
        $pendaftar->update([
            'hasil_keputusan' => $request->hasil_keputusan,
            'user_keputusan' => Auth::user()->nama,
            'tgl_keputusan' => now(),
            'catatan_keputusan' => $request->catatan_keputusan
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Keputusan berhasil disimpan'
        ]);
    }
}