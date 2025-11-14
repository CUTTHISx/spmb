<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendaftar_data_siswa', function (Blueprint $table) {
            $table->foreignId('province_id')->nullable()->after('alamat')->constrained('provinces')->onDelete('set null');
            $table->foreignId('regency_id')->nullable()->after('province_id')->constrained('regencies')->onDelete('set null');
            $table->foreignId('district_id')->nullable()->after('regency_id')->constrained('districts')->onDelete('set null');
            $table->foreignId('village_id')->nullable()->after('district_id')->constrained('villages')->onDelete('set null');
            $table->string('rt_rw')->nullable()->after('village_id');
        });
    }

    public function down()
    {
        Schema::table('pendaftar_data_siswa', function (Blueprint $table) {
            $table->dropForeign(['village_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['regency_id']);
            $table->dropForeign(['province_id']);
            $table->dropColumn(['province_id', 'regency_id', 'district_id', 'village_id', 'rt_rw']);
        });
    }
};