<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            
            $table->text('subtitle')->nullable();
            
            // ✅ TAMBAHAN BARU: Kolom Tagline (Wajib ada biar ga error)
            $table->string('tagline')->nullable(); 

            // ✅ PERBAIKAN: Ubah jadi nullable() agar tidak error 500 saat kosong
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();

            $table->enum('media_type', ['image', 'video'])->default('image');
            $table->string('media_path')->nullable(); 
            $table->string('video_embed')->nullable(); 
            
            // Platform video (sudah ada wistia)
            $table->enum('video_platform', ['youtube', 'instagram', 'vimeo', 'tiktok', 'custom', 'wistia'])->nullable();

            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_sliders');
    }
};