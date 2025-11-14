<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            DB::statement("ALTER TABLE pendaftar MODIFY COLUMN status_payment ENUM('PENDING', 'VERIFIED', 'REJECTED', 'REVISION') DEFAULT 'PENDING'");
            DB::statement("ALTER TABLE pendaftar MODIFY COLUMN status_berkas ENUM('PENDING', 'VERIFIED', 'REJECTED', 'REVISION') DEFAULT 'PENDING'");
            DB::statement("ALTER TABLE pendaftar MODIFY COLUMN status_data ENUM('PENDING', 'VERIFIED', 'REJECTED', 'REVISION') DEFAULT 'PENDING'");
        });
    }

    public function down()
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            DB::statement("ALTER TABLE pendaftar MODIFY COLUMN status_payment ENUM('PENDING', 'VERIFIED', 'REJECTED') DEFAULT 'PENDING'");
            DB::statement("ALTER TABLE pendaftar MODIFY COLUMN status_berkas ENUM('PENDING', 'VERIFIED', 'REJECTED') DEFAULT 'PENDING'");
            DB::statement("ALTER TABLE pendaftar MODIFY COLUMN status_data ENUM('PENDING', 'VERIFIED', 'REJECTED') DEFAULT 'PENDING'");
        });
    }
};