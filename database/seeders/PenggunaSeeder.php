<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class PenggunaSeeder extends Seeder
{
    public function run()
    {
        // Admin
        Pengguna::create([
            'nama' => 'Administrator',
            'email' => 'admin@ppdb.com',
            'password_hash' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Kepsek
        Pengguna::create([
            'nama' => 'Kepala Sekolah',
            'email' => 'kepsek@ppdb.com',
            'password_hash' => Hash::make('kepsek123'),
            'role' => 'kepsek',
        ]);

        // Keuangan
        Pengguna::create([
            'nama' => 'Staff Keuangan',
            'email' => 'keuangan@ppdb.com',
            'password_hash' => Hash::make('keuangan123'),
            'role' => 'keuangan',
        ]);

        // Verifikator
        Pengguna::create([
            'nama' => 'Staff Verifikator',
            'email' => 'verifikator@ppdb.com',
            'password_hash' => Hash::make('verifikator123'),
            'role' => 'verifikator',
        ]);

        // Verifikator Administrasi (legacy)
        Pengguna::create([
            'nama' => 'Staff Verifikator Administrasi',
            'email' => 'verifikator_adm@ppdb.com',
            'password_hash' => Hash::make('verifikator123'),
            'role' => 'verifikator_adm',
        ]);

        // Pendaftar
        Pengguna::create([
            'nama' => 'Ahmad Siswa',
            'email' => 'siswa@ppdb.com',
            'password_hash' => Hash::make('siswa123'),
            'role' => 'pendaftar',
        ]);
    }
}