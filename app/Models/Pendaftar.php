<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    protected $table = 'pendaftar';
    protected $fillable = [
        'user_id', 'gelombang_id', 'jurusan_id', 'no_pendaftaran', 'status', 
        'user_verifikasi_adm', 'tgl_verifikasi_adm', 'catatan_verifikasi',
        'user_verifikasi_payment', 'tgl_verifikasi_payment', 'status_payment',
        'user_verifikasi_berkas', 'tgl_verifikasi_berkas', 'status_berkas',
        'user_verifikasi_data', 'tgl_verifikasi_data', 'status_data'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }
    
    public function dataSiswa()
    {
        return $this->hasOne(PendaftarDataSiswa::class, 'pendaftar_id');
    }
    
    public function dataOrtu()
    {
        return $this->hasOne(PendaftarDataOrtu::class, 'pendaftar_id');
    }
    
    public function asalSekolah()
    {
        return $this->hasOne(PendaftarAsalSekolah::class, 'pendaftar_id');
    }
    
    public function berkas()
    {
        return $this->hasMany(PendaftarBerkas::class, 'pendaftar_id');
    }
    
    public function pembayaran()
    {
        return $this->hasOne(PendaftarPembayaran::class, 'pendaftar_id');
    }
    
    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class, 'gelombang_id');
    }
    
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}

