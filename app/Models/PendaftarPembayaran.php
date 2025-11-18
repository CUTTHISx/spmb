<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\FileUploadService;

class PendaftarPembayaran extends Model
{
    protected $table = 'pendaftar_pembayaran';
    
    protected $fillable = [
        'pendaftar_id',
        'nominal',
        'tgl_bayar',
        'tanggal_transfer',
        'nama_pengirim',
        'bukti_bayar',
        'bukti_pembayaran',
        'catatan',
        'status_verifikasi'
    ];

    protected $casts = [
        'tanggal_transfer' => 'date',
        'nominal' => 'decimal:0'
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }
    
    public function getBuktiPembayaranUrlAttribute()
    {
        return FileUploadService::getFileUrl($this->bukti_pembayaran);
    }
}