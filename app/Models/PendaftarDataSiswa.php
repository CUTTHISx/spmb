<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftarDataSiswa extends Model
{
    protected $table = 'pendaftar_data_siswa';
    protected $primaryKey = 'pendaftar_id';
    public $incrementing = false;
    protected $fillable = [
        'pendaftar_id', 
        'nik', 
        'nisn', 
        'nama',
        'jk', 
        'tmp_lahir', 
        'tgl_lahir', 
        'alamat', 
        'rt_rw',
        'wilayah_id',
        'lat',
        'lng'
    ];
    
    protected $casts = [
        'nik' => 'integer',
        'nisn' => 'integer',
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
    ];
    
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }
    
    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
    }
}
