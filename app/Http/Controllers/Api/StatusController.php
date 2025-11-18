<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function cekStatus(Request $request)
    {
        $request->validate([
            'no_pendaftaran' => 'required|string'
        ]);

        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'pembayaran'])
            ->where('no_pendaftaran', $request->no_pendaftaran)
            ->first();

        if (!$pendaftar) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor pendaftaran tidak ditemukan'
            ]);
        }

        // Status verifikasi
        $statusVerifikasi = 'PENDING';
        $statusVerifikasiText = 'Menunggu Verifikasi';
        
        if ($pendaftar->status_berkas == 'VERIFIED' && $pendaftar->status_data == 'VERIFIED') {
            $statusVerifikasi = 'VERIFIED';
            $statusVerifikasiText = 'Terverifikasi';
        } elseif ($pendaftar->status_berkas == 'REJECTED' || $pendaftar->status_data == 'REJECTED') {
            $statusVerifikasi = 'REJECTED';
            $statusVerifikasiText = 'Ditolak';
        }

        // Status pembayaran
        $statusPembayaran = 'PENDING';
        $statusPembayaranText = 'Menunggu Pembayaran';
        
        if ($pendaftar->pembayaran) {
            if ($pendaftar->pembayaran->status_verifikasi == 'VERIFIED') {
                $statusPembayaran = 'VERIFIED';
                $statusPembayaranText = 'Terbayar';
            } elseif ($pendaftar->pembayaran->status_verifikasi == 'REJECTED') {
                $statusPembayaran = 'REJECTED';
                $statusPembayaranText = 'Ditolak';
            } else {
                $statusPembayaranText = 'Menunggu Verifikasi';
            }
        }

        // Hasil keputusan
        $hasilKeputusan = $pendaftar->hasil_keputusan ?? 'BELUM_DIPUTUSKAN';
        $hasilKeputusanText = match($hasilKeputusan) {
            'LULUS' => 'Lulus',
            'TIDAK_LULUS' => 'Tidak Lulus',
            'CADANGAN' => 'Cadangan',
            default => 'Belum Diputuskan'
        };

        return response()->json([
            'success' => true,
            'data' => [
                'nama' => $pendaftar->dataSiswa->nama_lengkap ?? $pendaftar->dataSiswa->nama ?? $pendaftar->user->nama,
                'no_pendaftaran' => $pendaftar->no_pendaftaran,
                'jurusan' => $pendaftar->jurusan->nama ?? null,
                'status_verifikasi' => $statusVerifikasi,
                'status_verifikasi_text' => $statusVerifikasiText,
                'status_pembayaran' => $statusPembayaran,
                'status_pembayaran_text' => $statusPembayaranText,
                'hasil_keputusan' => $hasilKeputusan,
                'hasil_keputusan_text' => $hasilKeputusanText,
                'catatan' => $pendaftar->catatan_keputusan ?? $pendaftar->catatan_verifikasi
            ]
        ]);
    }
}