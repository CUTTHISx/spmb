<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $jurusan = [
            ['kode' => 'PPLG', 'nama' => 'Pengembangan Perangkat Lunak dan Gim', 'kuota' => 36],
            ['kode' => 'AKUNTANSI', 'nama' => 'Akuntansi dan Keuangan Lembaga', 'kuota' => 36],
            ['kode' => 'DKV', 'nama' => 'Desain Komunikasi Visual', 'kuota' => 36],
            ['kode' => 'ANIMASI', 'nama' => 'Animasi', 'kuota' => 36],
            ['kode' => 'BDP', 'nama' => 'Bisnis Daring dan Pemasaran', 'kuota' => 36],
        ];

        foreach ($jurusan as $j) {
            Jurusan::updateOrCreate(['kode' => $j['kode']], $j);
        }
    }
}