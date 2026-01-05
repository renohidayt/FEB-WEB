<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('accreditations', function (Blueprint $table) {
            // Add type field with enum
            $table->enum('type', [
                'perguruan_tinggi',      // Akreditasi PT saat ini
                'perguruan_tinggi_old',  // Akreditasi PT terdahulu
                'program_studi',         // Akreditasi Prodi saat ini (DEFAULT)
                'program_studi_old'      // Riwayat akreditasi prodi
            ])->default('program_studi')->after('id');
            
            // Add category field for sub-grouping (S1, S2, D3, etc.)
            $table->string('category', 100)->nullable()->after('type')
                  ->comment('Contoh: S1, S2, D3, atau NULL untuk PT');
            
            // Add indexes for performance
            $table->index('type', 'idx_accreditations_type');
            $table->index(['type', 'is_active'], 'idx_type_active');
            $table->index(['type', 'grade'], 'idx_type_grade');
            $table->index(['type', 'category'], 'idx_type_category');
        });

        // Update existing data: set all existing records as 'program_studi' (default sudah benar)
        // Jika Anda ingin mengubah data existing, uncomment baris berikut:
        
        // DB::table('accreditations')->update([
        //     'type' => 'program_studi',
        //     'category' => 'S1' // Sesuaikan dengan data Anda
        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accreditations', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex('idx_accreditations_type');
            $table->dropIndex('idx_type_active');
            $table->dropIndex('idx_type_grade');
            $table->dropIndex('idx_type_category');
            
            // Drop columns
            $table->dropColumn(['type', 'category']);
        });
    }
};