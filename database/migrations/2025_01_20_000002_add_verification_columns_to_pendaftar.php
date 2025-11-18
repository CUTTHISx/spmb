<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->enum('status_berkas', ['PENDING', 'VERIFIED', 'REJECTED', 'REVISION'])->default('PENDING')->after('status');
            $table->enum('status_data', ['PENDING', 'VERIFIED', 'REJECTED', 'REVISION'])->default('PENDING')->after('status_berkas');
            $table->string('user_verifikasi_berkas', 100)->nullable()->after('status_data');
            $table->dateTime('tgl_verifikasi_berkas')->nullable()->after('user_verifikasi_berkas');
            $table->string('user_verifikasi_data', 100)->nullable()->after('tgl_verifikasi_berkas');
            $table->dateTime('tgl_verifikasi_data')->nullable()->after('user_verifikasi_data');
            $table->text('catatan_verifikasi')->nullable()->after('tgl_verifikasi_data');
            $table->text('catatan_berkas')->nullable()->after('catatan_verifikasi');
            $table->text('catatan_data')->nullable()->after('catatan_berkas');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->dropColumn([
                'status_berkas', 'status_data', 'user_verifikasi_berkas', 
                'tgl_verifikasi_berkas', 'user_verifikasi_data', 
                'tgl_verifikasi_data', 'catatan_verifikasi', 'catatan_berkas', 'catatan_data'
            ]);
        });
    }
};