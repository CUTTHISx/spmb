<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\FileUploadService;

class PendaftarPembayaran extends Model
{
    protected $table = 'pendaftar_pembayaran';
    
    protected $fillable = [
        'pendaftar_id',
        'bukti_pembayaran',
        'nama_pengirim',
        'tanggal_transfer',
        'nominal',
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