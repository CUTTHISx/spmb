<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->enum('status_payment', ['PENDING', 'VERIFIED', 'REJECTED'])->default('PENDING')->after('tgl_verifikasi_payment');
            $table->integer('user_verifikasi_berkas')->nullable()->after('status_payment');
            $table->datetime('tgl_verifikasi_berkas')->nullable()->after('user_verifikasi_berkas');
            $table->enum('status_berkas', ['PENDING', 'VERIFIED', 'REJECTED'])->default('PENDING')->after('tgl_verifikasi_berkas');
            $table->integer('user_verifikasi_data')->nullable()->after('status_berkas');
            $table->datetime('tgl_verifikasi_data')->nullable()->after('user_verifikasi_data');
            $table->enum('status_data', ['PENDING', 'VERIFIED', 'REJECTED'])->default('PENDING')->after('tgl_verifikasi_data');
        });
    }

    public function down()
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->dropColumn([
                'status_payment', 'user_verifikasi_berkas', 'tgl_verifikasi_berkas', 
                'status_berkas', 'user_verifikasi_data', 'tgl_verifikasi_data', 'status_data'
            ]);
        });
    }
};