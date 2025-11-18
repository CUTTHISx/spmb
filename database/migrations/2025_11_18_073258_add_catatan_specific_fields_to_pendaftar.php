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
        Schema::table('pendaftar', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftar', 'catatan_berkas')) {
                $table->text('catatan_berkas')->nullable();
            }
            if (!Schema::hasColumn('pendaftar', 'catatan_data')) {
                $table->text('catatan_data')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->dropColumn(['catatan_berkas', 'catatan_data']);
        });
    }
};
