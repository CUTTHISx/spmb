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
Schema::create('log_aktivitas', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->unsignedBigInteger('user_id')->nullable();
    $table->string('aksi',100);
    $table->string('objek',100)->nullable();
    $table->json('objek_data')->nullable();
    $table->dateTime('waktu');
    $table->string('ip',45)->nullable();
    $table->timestamps();

    $table->index(['user_id','waktu']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
