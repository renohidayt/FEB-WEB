<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letter_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_template_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Data mahasiswa
            $table->string('nama_mahasiswa');
            $table->string('nim');
            $table->string('prodi')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            
            // Form data (JSON untuk menyimpan jawaban dari form builder)
            $table->json('form_data')->nullable();
            
            // File lampiran
            $table->json('attachments')->nullable();
            
            // Status pengajuan
            $table->enum('status', ['pending', 'processing', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->string('generated_letter_path')->nullable(); // Path file surat yang sudah di-generate
            
            // Tracking
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letter_submissions');
    }
};
