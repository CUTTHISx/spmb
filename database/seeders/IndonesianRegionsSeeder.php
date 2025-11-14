<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class IndonesianRegionsSeeder extends Seeder
{
    public function run()
    {
        // DKI Jakarta
        $jakarta = Province::create(['name' => 'DKI Jakarta']);
        
        $jakbar = Regency::create(['province_id' => $jakarta->id, 'name' => 'Jakarta Barat']);
        $jakpus = Regency::create(['province_id' => $jakarta->id, 'name' => 'Jakarta Pusat']);
        $jaksel = Regency::create(['province_id' => $jakarta->id, 'name' => 'Jakarta Selatan']);
        
        // Kecamatan Jakarta Barat
        $kebonjeruk = District::create(['regency_id' => $jakbar->id, 'name' => 'Kebon Jeruk']);
        $palmerah = District::create(['regency_id' => $jakbar->id, 'name' => 'Palmerah']);
        
        // Kelurahan Kebon Jeruk
        Village::create(['district_id' => $kebonjeruk->id, 'name' => 'Kebon Jeruk']);
        Village::create(['district_id' => $kebonjeruk->id, 'name' => 'Sukabumi Utara']);
        Village::create(['district_id' => $kebonjeruk->id, 'name' => 'Kelapa Dua']);
        
        // Kelurahan Palmerah
        Village::create(['district_id' => $palmerah->id, 'name' => 'Palmerah']);
        Village::create(['district_id' => $palmerah->id, 'name' => 'Slipi']);
        Village::create(['district_id' => $palmerah->id, 'name' => 'Kota Bambu Utara']);
        
        // Jawa Barat
        $jabar = Province::create(['name' => 'Jawa Barat']);
        
        $bandung = Regency::create(['province_id' => $jabar->id, 'name' => 'Kota Bandung']);
        $bekasi = Regency::create(['province_id' => $jabar->id, 'name' => 'Kota Bekasi']);
        
        // Kecamatan Bandung
        $coblong = District::create(['regency_id' => $bandung->id, 'name' => 'Coblong']);
        $sukasari = District::create(['regency_id' => $bandung->id, 'name' => 'Sukasari']);
        
        // Kelurahan Coblong
        Village::create(['district_id' => $coblong->id, 'name' => 'Lebak Gede']);
        Village::create(['district_id' => $coblong->id, 'name' => 'Sadang Serang']);
        
        // Kelurahan Sukasari
        Village::create(['district_id' => $sukasari->id, 'name' => 'Geger Kalong']);
        Village::create(['district_id' => $sukasari->id, 'name' => 'Sukarasa']);
        
        // Jawa Tengah
        $jateng = Province::create(['name' => 'Jawa Tengah']);
        
        $semarang = Regency::create(['province_id' => $jateng->id, 'name' => 'Kota Semarang']);
        
        $tembalang = District::create(['regency_id' => $semarang->id, 'name' => 'Tembalang']);
        
        Village::create(['district_id' => $tembalang->id, 'name' => 'Tembalang']);
        Village::create(['district_id' => $tembalang->id, 'name' => 'Bulusan']);
    }
}