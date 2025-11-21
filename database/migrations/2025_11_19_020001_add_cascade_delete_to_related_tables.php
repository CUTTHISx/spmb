<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pendaftar Data Siswa
        Schema::table('pendaftar_data_siswa', function (Blueprint $table) {
            $table->dropForeign(['pendaftar_id']);
            $table->foreign('pendaftar_id')->references('id')->on('pendaftar')->onDelete('cascade');
        });

        // Pendaftar Data Ortu
        Schema::table('pendaftar_data_ortu', function (Blueprint $table) {
            $table->dropForeign(['pendaftar_id']);
            $table->foreign('pendaftar_id')->references('id')->on('pendaftar')->onDelete('cascade');
        });

        // Pendaftar Asal Sekolah
        Schema::table('pendaftar_asal_sekolah', function (Blueprint $table) {
            $table->dropForeign(['pendaftar_id']);
            $table->foreign('pendaftar_id')->references('id')->on('pendaftar')->onDelete('cascade');
        });

        // Pendaftar Berkas
        Schema::table('pendaftar_berkas', function (Blueprint $table) {
            $table->dropForeign(['pendaftar_id']);
            $table->foreign('pendaftar_id')->references('id')->on('pendaftar')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftar_data_siswa', function (Blueprint $table) {
            $table->dropForeign(['pendaftar_id']);
            $table->foreign('pendaftar_id')->references('id')->on('pendaftar');
        });

        Schema::table('pendaftar_data_ortu', function (Blueprint $table) {
            $table->dropForeign(['pendaftar_id']);
            $table->foreign('pendaftar_id')->references('id')->on('pendaftar');
        });

        Schema::table('pendaftar_asal_sekolah', function (Blueprint $table) {
            $table->dropForeign(['pendaftar_id']);
            $table->foreign('pendaftar_id')->references('id')->on('pendaftar');
        });

        Schema::table('pendaftar_berkas', function (Blueprint $table) {
            $table->dropForeign(['pendaftar_id']);
            $table->foreign('pendaftar_id')->references('id')->on('pendaftar');
        });
    }
};