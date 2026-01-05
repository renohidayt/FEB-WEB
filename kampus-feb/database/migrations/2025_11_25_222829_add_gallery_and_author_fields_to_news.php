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
        // Add new fields to news table
        Schema::table('news', function (Blueprint $table) {
            $table->string('author_name')->nullable()->after('author_id');
            $table->text('excerpt')->nullable()->after('content');
            $table->unsignedInteger('reading_time')->default(0)->after('views');
        });

        // Create news_images table for gallery
        Schema::create('news_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained('news')->onDelete('cascade');
            $table->string('image_path');
            $table->string('caption')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('news_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['author_name', 'excerpt', 'reading_time']);
        });
        
        Schema::dropIfExists('news_images');
    }
};