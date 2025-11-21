<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftarBerkas extends Model
{
    protected $table = 'pendaftar_berkas';
    
    protected $fillable = [
        'pendaftar_id',
        'jenis',
        'nama_file',
        'url',
        'ukuran_kb',
        'valid',
        'catatan',
        'status_verifikasi',
        'catatan_verifikasi',
        'user_verifikasi',
        'tgl_verifikasi'
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }
    
    public function getFileUrlAttribute()
    {
        return asset($this->url);
    }
}