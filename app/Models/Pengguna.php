<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';
    protected $fillable = [
        'nama', 'email', 'hp', 'password_hash', 'role', 'aktif', 'status', 'verification_token'
    ];
    public $timestamps = true;
    
    protected $hidden = [
        'password_hash',
        'verification_token'
    ];
    
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
    
    public function getNameAttribute()
    {
        return $this->nama;
    }
}
