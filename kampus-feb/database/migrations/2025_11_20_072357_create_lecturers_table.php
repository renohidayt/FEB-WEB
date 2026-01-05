<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            
            // Personal Info
            $table->string('name')->index();
            $table->string('nidn', 50)->unique()->index(); // NIDN harus unique
            
            // Position & Academic
            $table->string('position', 100)->nullable();
            $table->string('study_program', 100)->nullable()->index();
            $table->text('expertise')->nullable();
            
            // Contact
            $table->string('email')->nullable()->index();
            $table->string('phone', 20)->nullable();
            
            // Academic Info
            $table->text('courses_taught')->nullable();
            $table->string('academic_degree', 50)->nullable(); // S1, S2, S3, Prof
            $table->text('education_history')->nullable(); // JSON or TEXT
            $table->text('research_interests')->nullable();
            
            // Media
            $table->string('photo')->nullable();
            
            // Status & Visibility
            $table->boolean('is_visible')->default(true)->index();
            $table->boolean('is_active')->default(true)->index(); // Status kepegawaian
            
            // SEO & Metadata
            $table->string('slug')->unique()->nullable();
            $table->unsignedInteger('profile_views')->default(0);
            
            // Soft Deletes for data integrity
            $table->softDeletes();
            
            $table->timestamps();
            
            // Indexes untuk performance
            $table->index('created_at');
            $table->index(['is_visible', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};