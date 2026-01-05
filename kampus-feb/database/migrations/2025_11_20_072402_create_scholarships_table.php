<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index(); // Index untuk performa search
            $table->enum('type', ['prestasi', 'kip-k', 'pemerintah', 'internal', 'swasta', 'tahfidz', 'penelitian']);
            $table->enum('category', ['pemerintah', 'internal', 'prestasi', 'bantuan_ukt', 'swasta', 'tahfidz', 'penelitian'])->index();
            
            // PERBAIKAN: amount sebagai decimal, bukan string
            $table->decimal('amount', 15, 2)->nullable();
            
            $table->string('poster')->nullable();
            $table->text('description');
            $table->text('requirements');
            
            // Tambahan field yang ada di controller tapi tidak di migration
            $table->string('provider')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->string('contact_email')->nullable();
            $table->string('website_url', 500)->nullable();
            
            $table->date('registration_start')->nullable()->index();
            $table->date('registration_end')->nullable()->index();
            $table->date('announcement_date')->nullable();
            
            $table->unsignedInteger('quota')->nullable();
            $table->unsignedInteger('views')->default(0);
            
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_featured')->default(false)->index();
            
            $table->timestamps();
            
            // Indexes untuk performa
            $table->index('created_at');
            $table->index(['is_active', 'is_featured']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};