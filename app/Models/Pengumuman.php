<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';
    
    protected $fillable = [
        'judul',
        'isi',
        'tanggal_pengumuman',
        'jam_pengumuman', 
        'is_active',
        'status',
        'updated_by'
    ];
    
    protected $casts = [
        'tanggal_pengumuman' => 'date'
    ];
    
    public function isActive()
    {
        return $this->is_active == true;
    }
}