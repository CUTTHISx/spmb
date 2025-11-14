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
Schema::create('pendaftar_asal_sekolah', function (Blueprint $table) {
    $table->unsignedBigInteger('pendaftar_id')->primary();
    $table->string('npsn',20)->nullable();
    $table->string('nama_sekolah',150)->nullable();
    $table->string('kabupaten',100)->nullable();
    $table->decimal('nilai_rata',5,2)->nullable();
    $table->timestamps();

    $table->foreign('pendaftar_id')->references('id')->on('pendaftar')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftar_asal_sekolah');
    }
};
