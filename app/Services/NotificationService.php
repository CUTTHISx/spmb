<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Pengguna;

class NotificationService
{
    public static function send($userId, $title, $message, $type = 'info', $data = [])
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data
        ]);
    }

    public static function sendToRole($role, $title, $message, $type = 'info', $data = [])
    {
        $users = Pengguna::where('role', $role)->get();
        
        foreach ($users as $user) {
            self::send($user->id, $title, $message, $type, $data);
        }
    }

    // Notifikasi untuk verifikasi berkas
    public static function berkasVerified($pendaftarId, $status, $catatan = '')
    {
        $pendaftar = \App\Models\Pendaftar::with('user')->find($pendaftarId);
        
        if ($status === 'VERIFIED') {
            self::send(
                $pendaftar->user_id,
                'Berkas Diverifikasi',
                'Selamat! Berkas Anda telah diverifikasi dan diterima.',
                'success',
                ['pendaftar_id' => $pendaftarId, 'catatan' => $catatan]
            );
        } elseif ($status === 'REJECTED') {
            self::send(
                $pendaftar->user_id,
                'Berkas Ditolak',
                'Berkas Anda ditolak. Catatan: ' . $catatan,
                'danger',
                ['pendaftar_id' => $pendaftarId, 'catatan' => $catatan]
            );
        } else {
            self::send(
                $pendaftar->user_id,
                'Berkas Perlu Revisi',
                'Berkas Anda perlu diperbaiki. Catatan: ' . $catatan,
                'warning',
                ['pendaftar_id' => $pendaftarId, 'catatan' => $catatan]
            );
        }
    }

    // Notifikasi untuk verifikasi pembayaran
    public static function paymentVerified($pendaftarId, $status, $catatan = '')
    {
        $pendaftar = \App\Models\Pendaftar::with('user')->find($pendaftarId);
        
        if ($status === 'VERIFIED') {
            self::send(
                $pendaftar->user_id,
                'Pembayaran Diverifikasi',
                'Pembayaran Anda telah diverifikasi. Terima kasih!',
                'success',
                ['pendaftar_id' => $pendaftarId, 'catatan' => $catatan]
            );
        } else {
            self::send(
                $pendaftar->user_id,
                'Pembayaran Ditolak',
                'Pembayaran Anda ditolak. Catatan: ' . ($catatan ?: 'Silakan upload bukti pembayaran yang valid.'),
                'danger',
                ['pendaftar_id' => $pendaftarId, 'catatan' => $catatan]
            );
        }
    }
    
    // Notifikasi untuk verifikasi data
    public static function dataVerified($pendaftarId, $status, $catatan = '')
    {
        $pendaftar = \App\Models\Pendaftar::with('user')->find($pendaftarId);
        
        if ($status === 'VERIFIED') {
            self::send(
                $pendaftar->user_id,
                'Data Diverifikasi',
                'Data pendaftaran Anda telah diverifikasi dan diterima.',
                'success',
                ['pendaftar_id' => $pendaftarId, 'catatan' => $catatan]
            );
        } elseif ($status === 'REJECTED') {
            self::send(
                $pendaftar->user_id,
                'Data Ditolak',
                'Data pendaftaran Anda ditolak. Catatan: ' . $catatan,
                'danger',
                ['pendaftar_id' => $pendaftarId, 'catatan' => $catatan]
            );
        } else {
            self::send(
                $pendaftar->user_id,
                'Data Perlu Revisi',
                'Data pendaftaran Anda perlu diperbaiki. Catatan: ' . $catatan,
                'warning',
                ['pendaftar_id' => $pendaftarId, 'catatan' => $catatan]
            );
        }
    }

    // Notifikasi pendaftar baru untuk admin
    public static function newRegistration($pendaftarId)
    {
        $pendaftar = \App\Models\Pendaftar::with(['user', 'jurusan'])->find($pendaftarId);
        
        self::sendToRole(
            'admin',
            'Pendaftar Baru',
            "Pendaftar baru: {$pendaftar->user->name} - Jurusan {$pendaftar->jurusan->nama}",
            'info',
            ['pendaftar_id' => $pendaftarId]
        );
    }
}