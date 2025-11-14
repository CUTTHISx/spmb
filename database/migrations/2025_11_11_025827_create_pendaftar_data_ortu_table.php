<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
Schema::create('pendaftar_data_ortu', function (Blueprint $table) {
    $table->unsignedBigInteger('pendaftar_id')->primary();
    $table->string('nama_ayah',120)->nullable();
    $table->string('pekerjaan_ayah',100)->nullable();
    $table->string('hp_ayah',20)->nullable();
    $table->string('nama_ibu',120)->nullable();
    $table->string('pekerjaan_ibu',100)->nullable();
    $table->string('hp_ibu',20)->nullable();
    $table->string('wali_nama',120)->nullable();
    $table->string('wali_hp',20)->nullable();
    $table->timestamps();

    $table->foreign('pendaftar_id')->references('id')->on('pendaftar')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftar_data_ortu');
    }
};
