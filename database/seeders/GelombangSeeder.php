<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gelombang;

class GelombangSeeder extends Seeder
{
    public function run(): void
    {
        $gelombang = [
            [
                'nama' => 'Gelombang 1',
                'tahun' => 2024,
                'tgl_mulai' => '2024-11-01',
                'tgl_selesai' => '2024-12-31',
                'biaya_daftar' => 250000,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Gelombang 2', 
                'tahun' => 2024,
                'tgl_mulai' => '2025-01-01',
                'tgl_selesai' => '2025-02-28',
                'biaya_daftar' => 300000,
                'status' => 'non-aktif'
            ]
        ];

        foreach ($gelombang as $g) {
            Gelombang::updateOrCreate(['nama' => $g['nama'], 'tahun' => $g['tahun']], $g);
        }
    }
}