<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftar_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained('pendaftar')->onDelete('cascade');
            $table->string('bukti_pembayaran');
            $table->string('nama_pengirim');
            $table->date('tanggal_transfer');
            $table->decimal('nominal', 10, 0);
            $table->text('catatan')->nullable();
            $table->enum('status_verifikasi', ['PENDING', 'VERIFIED', 'REJECTED'])->default('PENDING');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftar_pembayaran');
    }
};