<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            $table->string('judul')->after('id');
            $table->text('isi')->after('judul');
            $table->date('tanggal_pengumuman')->after('isi');
            $table->time('jam_pengumuman')->after('tanggal_pengumuman');
            $table->boolean('is_active')->default(false)->after('jam_pengumuman');
        });
    }

    public function down(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            $table->dropColumn(['judul', 'isi', 'tanggal_pengumuman', 'jam_pengumuman', 'is_active']);
        });
    }
};