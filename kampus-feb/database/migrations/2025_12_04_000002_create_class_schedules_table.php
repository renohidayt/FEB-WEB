<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('academic_year'); // 2024/2025
            $table->enum('semester', ['ganjil', 'genap']);
            $table->string('program_studi');
            $table->integer('semester_level'); // Semester 1, 2, 3, dst
            $table->string('course_code', 20);
            $table->string('course_name');
            $table->integer('sks');
            $table->foreignId('lecturer_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('day', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu']);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room')->nullable();
            $table->string('class_name')->nullable(); // Kelas A, B, C
            $table->integer('capacity')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
