<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
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
}
