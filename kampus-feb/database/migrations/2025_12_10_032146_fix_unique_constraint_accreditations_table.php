<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Menghapus constraint lama dan membuat yang baru dengan type
     */
    public function up(): void
    {
        Schema::table('accreditations', function (Blueprint $table) {
            // Drop constraint lama
            $table->dropUnique('unique_program_certificate');
            
            // Buat constraint baru yang include type
            // Sekarang: kombinasi (type, study_program, certificate_number) harus unique
            $table->unique(
                ['type', 'study_program', 'certificate_number'], 
                'unique_type_program_certificate'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accreditations', function (Blueprint $table) {
            // Drop constraint baru
            $table->dropUnique('unique_type_program_certificate');
            
            // Restore constraint lama
            $table->unique(
                ['study_program', 'certificate_number'], 
                'unique_program_certificate'
            );
        });
    }
};