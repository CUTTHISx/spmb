<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@ppdb.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Kepsek
        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@ppdb.com',
            'password' => Hash::make('kepsek123'),
            'role' => 'kepsek',
            'email_verified_at' => now(),
        ]);

        // Keuangan
        User::create([
            'name' => 'Staff Keuangan',
            'email' => 'keuangan@ppdb.com',
            'password' => Hash::make('keuangan123'),
            'role' => 'keuangan',
            'email_verified_at' => now(),
        ]);

        // Verifikator Administrasi
        User::create([
            'name' => 'Staff Verifikator Administrasi',
            'email' => 'verifikator@ppdb.com',
            'password' => Hash::make('verifikator123'),
            'role' => 'verifikator_adm',
            'email_verified_at' => now(),
        ]);

        // Pendaftar
        User::create([
            'name' => 'Ahmad Siswa',
            'email' => 'siswa@ppdb.com',
            'password' => Hash::make('siswa123'),
            'role' => 'pendaftar',
            'email_verified_at' => now(),
        ]);

        // Pendaftar Bikri
        User::create([
            'name' => 'Bikri Pendaftar',
            'email' => 'bikri@ppdb.com',
            'password' => Hash::make('bikri123'),
            'role' => 'pendaftar',
            'email_verified_at' => now(),
        ]);
    }
}