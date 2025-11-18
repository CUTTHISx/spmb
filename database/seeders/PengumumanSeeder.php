<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengumuman;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        Pengumuman::create([
            'judul' => 'Pengumuman Hasil PPDB 2025',
            'isi' => 'Hasil seleksi PPDB telah diumumkan',
            'tanggal_pengumuman' => now(),
            'jam_pengumuman' => '08:00',
            'is_active' => true
        ]);
    }
}