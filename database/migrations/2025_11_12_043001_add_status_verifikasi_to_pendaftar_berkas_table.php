<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftar_berkas', function (Blueprint $table) {
            $table->enum('status_verifikasi', ['PENDING', 'APPROVED', 'REJECTED', 'REVISION'])->default('PENDING')->after('valid');
            $table->text('catatan_verifikasi')->nullable()->after('status_verifikasi');
            $table->unsignedBigInteger('user_verifikasi')->nullable()->after('catatan_verifikasi');
            $table->timestamp('tgl_verifikasi')->nullable()->after('user_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftar_berkas', function (Blueprint $table) {
            $table->dropColumn(['status_verifikasi', 'catatan_verifikasi', 'user_verifikasi', 'tgl_verifikasi']);
        });
    }
};