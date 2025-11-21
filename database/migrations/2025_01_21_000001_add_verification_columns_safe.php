<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftar', 'status_berkas')) {
                $table->enum('status_berkas', ['PENDING', 'VERIFIED', 'REJECTED', 'REVISION'])->default('PENDING')->after('status');
            }
            if (!Schema::hasColumn('pendaftar', 'status_data')) {
                $table->enum('status_data', ['PENDING', 'VERIFIED', 'REJECTED', 'REVISION'])->default('PENDING')->after('status_berkas');
            }
            if (!Schema::hasColumn('pendaftar', 'user_verifikasi_berkas')) {
                $table->string('user_verifikasi_berkas', 100)->nullable()->after('status_data');
            }
            if (!Schema::hasColumn('pendaftar', 'tgl_verifikasi_berkas')) {
                $table->dateTime('tgl_verifikasi_berkas')->nullable()->after('user_verifikasi_berkas');
            }
            if (!Schema::hasColumn('pendaftar', 'user_verifikasi_data')) {
                $table->string('user_verifikasi_data', 100)->nullable()->after('tgl_verifikasi_berkas');
            }
            if (!Schema::hasColumn('pendaftar', 'tgl_verifikasi_data')) {
                $table->dateTime('tgl_verifikasi_data')->nullable()->after('user_verifikasi_data');
            }
            if (!Schema::hasColumn('pendaftar', 'catatan_verifikasi')) {
                $table->text('catatan_verifikasi')->nullable()->after('tgl_verifikasi_data');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $columns = ['status_berkas', 'status_data', 'user_verifikasi_berkas', 
                       'tgl_verifikasi_berkas', 'user_verifikasi_data', 
                       'tgl_verifikasi_data', 'catatan_verifikasi'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('pendaftar', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};