<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftarAsalSekolah extends Model
{
    protected $table = 'pendaftar_asal_sekolah';
    protected $primaryKey = 'pendaftar_id';
    public $incrementing = false;
    protected $fillable = [
        'pendaftar_id', 
        'npsn',
        'nama_sekolah', 
        'kabupaten', 
        'nilai_rata'
    ];
    
    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
    }
}
