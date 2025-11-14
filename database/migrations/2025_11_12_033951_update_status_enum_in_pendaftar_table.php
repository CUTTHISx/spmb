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
            $table->enum('status', [
                'DRAFT', 
                'SUBMITTED', 
                'VERIFIED_ADM', 
                'REJECTED_ADM',
                'WAITING_PAYMENT', 
                'PAID', 
                'VERIFIED_PAYMENT', 
                'REJECTED_PAYMENT',
                'ACCEPTED', 
                'REJECTED', 
                'WAITING_LIST'
            ])->default('DRAFT')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->enum('status', ['DRAFT', 'SUBMITTED', 'VERIFIED', 'REJECTED'])->default('DRAFT')->change();
        });
    }
};
