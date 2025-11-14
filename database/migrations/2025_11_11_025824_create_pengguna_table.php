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
Schema::create('pengguna', function (Blueprint $table) {
    $table->id();
    $table->string('nama',100);
    $table->string('email',120)->unique();
    $table->string('hp',20)->nullable();
    $table->string('password_hash',255);
    $table->enum('role',['pendaftar','admin','verifikator_adm','keuangan','kepsek']);
    $table->string('status')->default('pending');
    $table->string('verification_token')->nullable();
    $table->tinyInteger('aktif')->default(1);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
