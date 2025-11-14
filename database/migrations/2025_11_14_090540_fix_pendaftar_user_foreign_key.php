<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Delete orphaned records first
        DB::statement('DELETE FROM pendaftar WHERE user_id NOT IN (SELECT id FROM users)');
        
        // Try to drop existing foreign key (ignore if doesn't exist)
        try {
            DB::statement('ALTER TABLE pendaftar DROP FOREIGN KEY pendaftar_user_id_foreign');
        } catch (Exception $e) {
            // Ignore if foreign key doesn't exist
        }
        
        // Add new foreign key to pengguna table (as per specification)
        DB::statement('ALTER TABLE pendaftar ADD CONSTRAINT pendaftar_user_id_foreign FOREIGN KEY (user_id) REFERENCES pengguna(id)');
    }

    public function down(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            // Drop current foreign key
            $table->dropForeign(['user_id']);
            
            // Restore original foreign key
            $table->foreign('user_id')->references('id')->on('pengguna');
        });
    }
};