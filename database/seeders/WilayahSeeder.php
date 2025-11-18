<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wilayah;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        $wilayahData = [
            // Bandung
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Bandung', 'kecamatan' => 'Bandung Wetan', 'kelurahan' => 'Cihapit', 'kodepos' => '40114'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Bandung', 'kecamatan' => 'Bandung Wetan', 'kelurahan' => 'Citarum', 'kodepos' => '40115'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Bandung', 'kecamatan' => 'Coblong', 'kelurahan' => 'Dago', 'kodepos' => '40135'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Bandung', 'kecamatan' => 'Coblong', 'kelurahan' => 'Lebak Gede', 'kodepos' => '40132'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Bandung', 'kecamatan' => 'Cicendo', 'kelurahan' => 'Arjuna', 'kodepos' => '40172'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Bandung', 'kecamatan' => 'Cicendo', 'kelurahan' => 'Husein Sastranegara', 'kodepos' => '40174'],
            
            // Bekasi
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Bekasi', 'kecamatan' => 'Bekasi Barat', 'kelurahan' => 'Bintara', 'kodepos' => '17134'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Bekasi', 'kecamatan' => 'Bekasi Barat', 'kelurahan' => 'Kranji', 'kodepos' => '17135'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Bekasi', 'kecamatan' => 'Bekasi Timur', 'kelurahan' => 'Aren Jaya', 'kodepos' => '17111'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Bekasi', 'kecamatan' => 'Bekasi Timur', 'kelurahan' => 'Margahayu', 'kodepos' => '17113'],
            
            // Bogor
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Bogor', 'kecamatan' => 'Bogor Tengah', 'kelurahan' => 'Paledang', 'kodepos' => '16122'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Bogor', 'kecamatan' => 'Bogor Tengah', 'kelurahan' => 'Tegallega', 'kodepos' => '16129'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Bogor', 'kecamatan' => 'Bogor Utara', 'kelurahan' => 'Tegal Gundil', 'kodepos' => '16152'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Bogor', 'kecamatan' => 'Bogor Selatan', 'kelurahan' => 'Mulyaharja', 'kodepos' => '16135'],
            
            // Depok
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Depok', 'kecamatan' => 'Pancoran Mas', 'kelurahan' => 'Depok', 'kodepos' => '16431'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Depok', 'kecamatan' => 'Pancoran Mas', 'kelurahan' => 'Pancoran Mas', 'kodepos' => '16436'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Depok', 'kecamatan' => 'Beji', 'kelurahan' => 'Beji', 'kodepos' => '16421'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Depok', 'kecamatan' => 'Beji', 'kelurahan' => 'Kemiri Muka', 'kodepos' => '16423'],
            
            // Cimahi
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Cimahi', 'kecamatan' => 'Cimahi Tengah', 'kelurahan' => 'Cimahi', 'kodepos' => '40525'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Cimahi', 'kecamatan' => 'Cimahi Utara', 'kelurahan' => 'Cipageran', 'kodepos' => '40533'],
            
            // Kabupaten Bandung
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Bandung', 'kecamatan' => 'Cileunyi', 'kelurahan' => 'Cileunyi Kulon', 'kodepos' => '40622'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Bandung', 'kecamatan' => 'Dayeuhkolot', 'kelurahan' => 'Dayeuhkolot', 'kodepos' => '40258'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Bandung', 'kecamatan' => 'Baleendah', 'kelurahan' => 'Baleendah', 'kodepos' => '40375'],
            
            // Kabupaten Bogor
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Bogor', 'kecamatan' => 'Cibinong', 'kelurahan' => 'Cibinong', 'kodepos' => '16911'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Bogor', 'kecamatan' => 'Gunung Putri', 'kelurahan' => 'Gunung Putri', 'kodepos' => '16963'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Bogor', 'kecamatan' => 'Citeureup', 'kelurahan' => 'Citeureup', 'kodepos' => '16810'],
            
            // Tasikmalaya
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Tasikmalaya', 'kecamatan' => 'Tawang', 'kelurahan' => 'Tawang', 'kodepos' => '46112'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Tasikmalaya', 'kecamatan' => 'Mangkubumi', 'kelurahan' => 'Mangkubumi', 'kodepos' => '46181'],
            
            // Cirebon
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Cirebon', 'kecamatan' => 'Kejaksan', 'kelurahan' => 'Kejaksan', 'kodepos' => '45122'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Cirebon', 'kecamatan' => 'Lemahwungkuk', 'kelurahan' => 'Lemahwungkuk', 'kodepos' => '45111'],
            
            // Sukabumi
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kota Sukabumi', 'kecamatan' => 'Gunungpuyuh', 'kelurahan' => 'Gunungpuyuh', 'kodepos' => '43122'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Sukabumi', 'kecamatan' => 'Palabuhanratu', 'kelurahan' => 'Palabuhanratu', 'kodepos' => '43364'],
            
            // Garut
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Garut', 'kecamatan' => 'Garut Kota', 'kelurahan' => 'Garut Kota', 'kodepos' => '44117'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Garut', 'kecamatan' => 'Tarogong Kidul', 'kelurahan' => 'Tarogong Kidul', 'kodepos' => '44151'],
            
            // Cianjur
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Cianjur', 'kecamatan' => 'Cianjur', 'kelurahan' => 'Cianjur', 'kodepos' => '43211'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Cianjur', 'kecamatan' => 'Pacet', 'kelurahan' => 'Pacet', 'kodepos' => '43253'],
            
            // Purwakarta
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Purwakarta', 'kecamatan' => 'Purwakarta', 'kelurahan' => 'Purwakarta', 'kodepos' => '41111'],
            
            // Karawang
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Karawang', 'kecamatan' => 'Karawang Barat', 'kelurahan' => 'Karawang Barat', 'kodepos' => '41311'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Karawang', 'kecamatan' => 'Karawang Timur', 'kelurahan' => 'Karawang Timur', 'kodepos' => '41314'],
            
            // Subang
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Subang', 'kecamatan' => 'Subang', 'kelurahan' => 'Subang', 'kodepos' => '41211'],
            
            // Indramayu
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Indramayu', 'kecamatan' => 'Indramayu', 'kelurahan' => 'Indramayu', 'kodepos' => '45212'],
            
            // Kuningan
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Kuningan', 'kecamatan' => 'Kuningan', 'kelurahan' => 'Kuningan', 'kodepos' => '45511'],
            
            // Majalengka
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Kabupaten Majalengka', 'kecamatan' => 'Majalengka', 'kelurahan' => 'Majalengka', 'kodepos' => '45411']
        ];

        foreach ($wilayahData as $wilayah) {
            Wilayah::create($wilayah);
        }
    }
}