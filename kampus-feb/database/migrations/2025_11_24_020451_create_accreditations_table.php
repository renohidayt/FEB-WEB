<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accreditations', function (Blueprint $table) {
            $table->id();
            
            // Program Information
            $table->string('study_program')->index(); // Program Studi
            $table->enum('grade', ['A', 'B', 'C', 'Unggul', 'Baik Sekali', 'Baik'])->index(); // Peringkat
            
            // Accreditation Body
            $table->string('accreditation_body', 100)->default('BAN-PT'); // Lembaga akreditasi
            $table->string('certificate_number', 100)->unique()->nullable(); // No. Sertifikat (UNIQUE!)
            
            // Certificate File
            $table->string('certificate_file')->nullable(); // File sertifikat PDF
            
            // Validity Period
            $table->date('valid_from')->nullable()->index(); // Berlaku dari
            $table->date('valid_until')->index(); // Berlaku sampai
            
            // Status & Meta
            $table->boolean('is_active')->default(true)->index(); // Status aktif
            $table->text('description')->nullable(); // Deskripsi
            
            // SEO & Display
            $table->string('slug')->unique()->nullable();
            $table->unsignedInteger('download_count')->default(0); // Track downloads
            
            // Soft Deletes untuk data integrity
            $table->softDeletes();
            
            $table->timestamps();
            
            // Indexes untuk performance
            $table->index('created_at');
            $table->index(['is_active', 'valid_until']);
            
            // Unique constraint untuk mencegah duplikasi
            $table->unique(['study_program', 'certificate_number'], 'unique_program_certificate');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accreditations');
    }
};