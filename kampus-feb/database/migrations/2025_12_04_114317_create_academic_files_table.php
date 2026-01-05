<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_files', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['kalender', 'jadwal']); // Kalender Akademik atau Jadwal
            $table->string('title'); // Judul file
            $table->text('description')->nullable();
            $table->string('file_path'); // Path file
            $table->string('file_name'); // Nama file asli
            $table->string('file_type'); // pdf, csv, excel, dll
            $table->integer('file_size'); // dalam bytes
            $table->string('academic_year'); // 2024/2025
            $table->enum('semester', ['ganjil', 'genap']);
            $table->boolean('is_active')->default(true);
            $table->integer('download_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_files');
    }
};
