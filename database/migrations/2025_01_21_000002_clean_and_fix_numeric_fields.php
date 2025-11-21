<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Clean invalid data first
        DB::table('pendaftar_data_siswa')->whereRaw('nik REGEXP "[^0-9]"')->update(['nik' => null]);
        DB::table('pendaftar_data_siswa')->whereRaw('nisn REGEXP "[^0-9]"')->update(['nisn' => null]);
        
        DB::table('pendaftar_data_ortu')->whereRaw('hp_ayah REGEXP "[^0-9]"')->update(['hp_ayah' => null]);
        DB::table('pendaftar_data_ortu')->whereRaw('hp_ibu REGEXP "[^0-9]"')->update(['hp_ibu' => null]);
        DB::table('pendaftar_data_ortu')->whereRaw('wali_hp REGEXP "[^0-9]"')->update(['wali_hp' => null]);

        // Now modify the columns
        Schema::table('pendaftar_data_siswa', function (Blueprint $table) {
            $table->bigInteger('nik')->nullable()->change();
            $table->bigInteger('nisn')->nullable()->change();
        });

        Schema::table('pendaftar_data_ortu', function (Blueprint $table) {
            $table->bigInteger('hp_ayah')->nullable()->change();
            $table->bigInteger('hp_ibu')->nullable()->change();
            $table->bigInteger('wali_hp')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pendaftar_data_siswa', function (Blueprint $table) {
            $table->string('nik')->nullable()->change();
            $table->string('nisn')->nullable()->change();
        });

        Schema::table('pendaftar_data_ortu', function (Blueprint $table) {
            $table->string('hp_ayah')->nullable()->change();
            $table->string('hp_ibu')->nullable()->change();
            $table->string('wali_hp')->nullable()->change();
        });
    }
};