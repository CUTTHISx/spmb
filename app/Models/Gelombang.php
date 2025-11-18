<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gelombang extends Model
{
    protected $table = 'gelombang';
    protected $guarded = [];
    
    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'is_active' => 'boolean',
    ];
    
    public function pendaftar()
    {
        return $this->hasMany(Pendaftar::class, 'gelombang_id');
    }
}
