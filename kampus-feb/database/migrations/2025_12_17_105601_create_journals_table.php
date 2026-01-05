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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Jurnal
            $table->string('slug')->unique();
            $table->text('description')->nullable(); // Deskripsi jurnal
            $table->string('field')->nullable(); // Bidang/Fokus Jurnal
            $table->string('issn')->nullable(); // ISSN Print
            $table->string('e_issn')->nullable(); // e-ISSN Online
            $table->string('manager')->nullable(); // Pengelola (Fakultas/Prodi)
            
            // Status & Akreditasi
            $table->enum('accreditation_status', [
                'SINTA 1',
                'SINTA 2', 
                'SINTA 3',
                'SINTA 4',
                'SINTA 5',
                'SINTA 6',
                'Nasional Terakreditasi',
                'Nasional',
                'Internasional'
            ])->nullable();
            
            // URLs
            $table->string('website_url')->nullable(); // Website Jurnal (OJS)
            $table->string('submit_url')->nullable(); // URL Submit Artikel
            $table->string('sinta_url')->nullable(); // Link SINTA
            $table->string('garuda_url')->nullable(); // Link Garuda
            $table->string('scholar_url')->nullable(); // Link Google Scholar
            
            // Cover & Visual
            $table->string('cover_image')->nullable(); // Cover jurnal
            
            // Publication Info
            $table->string('frequency')->nullable(); // Frekuensi terbit (misal: 2x/tahun)
            $table->string('editor_in_chief')->nullable(); // Pemimpin Redaksi
            $table->string('publisher')->nullable(); // Penerbit
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_visible')->default(true);
            $table->integer('view_count')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};