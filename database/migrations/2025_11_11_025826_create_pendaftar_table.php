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
Schema::create('pendaftar', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('gelombang_id');
    $table->string('no_pendaftaran',20)->unique();
    $table->enum('status',['SUBMIT','ADM_PASS','ADM_REJECT','PAID'])->default('SUBMIT');
    $table->string('user_verifikasi_adm',100)->nullable();
    $table->dateTime('tgl_verifikasi_adm')->nullable();
    $table->string('user_verifikasi_payment',100)->nullable();
    $table->dateTime('tgl_verifikasi_payment')->nullable();
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('pengguna');
    $table->foreign('gelombang_id')->references('id')->on('gelombang');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftar');
    }
};
