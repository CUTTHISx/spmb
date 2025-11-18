<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->enum('hasil_keputusan', ['LULUS', 'TIDAK_LULUS', 'CADANGAN'])->nullable()->after('status');
            $table->string('user_keputusan', 100)->nullable()->after('hasil_keputusan');
            $table->dateTime('tgl_keputusan')->nullable()->after('user_keputusan');
            $table->text('catatan_keputusan')->nullable()->after('tgl_keputusan');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->dropColumn(['hasil_keputusan', 'user_keputusan', 'tgl_keputusan', 'catatan_keputusan']);
        });
    }
};