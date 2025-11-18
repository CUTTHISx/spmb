<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayah';
    
    protected $fillable = [
        'nama',
        'provinsi',
        'kabupaten', 
        'kecamatan',
        'kelurahan',
        'kodepos'
    ];
    
    public function getNamaAttribute()
    {
        return $this->attributes['nama'] ?? ($this->kelurahan . ', ' . $this->kecamatan . ', ' . $this->kabupaten);
    }
}