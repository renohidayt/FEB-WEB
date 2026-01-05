<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Check and add each column if not exists
            if (!Schema::hasColumn('news', 'slug')) {
                $table->string('slug')->unique()->after('title');
            }
            
            if (!Schema::hasColumn('news', 'author_name')) {
                $table->string('author_name')->nullable()->after('author_id');
            }
            
            if (!Schema::hasColumn('news', 'excerpt')) {
                $table->text('excerpt')->nullable()->after('content');
            }
            
            if (!Schema::hasColumn('news', 'meta_title')) {
                $table->string('meta_title', 60)->nullable()->after('content');
            }
            
            if (!Schema::hasColumn('news', 'meta_description')) {
                $table->string('meta_description', 160)->nullable()->after('meta_title');
            }
            
            if (!Schema::hasColumn('news', 'meta_keywords')) {
                $table->string('meta_keywords')->nullable()->after('meta_description');
            }
            
            if (!Schema::hasColumn('news', 'reading_time')) {
                $table->unsignedInteger('reading_time')->default(0)->after('views');
            }
        });

        // Create news_images table
        if (!Schema::hasTable('news_images')) {
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
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $columns = [
                'slug', 
                'author_name', 
                'excerpt', 
                'meta_title', 
                'meta_description', 
                'meta_keywords', 
                'reading_time'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('news', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
        
        Schema::dropIfExists('news_images');
    }
};