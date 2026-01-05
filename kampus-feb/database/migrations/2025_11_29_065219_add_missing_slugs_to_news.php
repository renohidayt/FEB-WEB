<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Get all news without slug
        $newsWithoutSlug = DB::table('news')
            ->whereNull('slug')
            ->orWhere('slug', '')
            ->get();

        foreach ($newsWithoutSlug as $news) {
            $slug = Str::slug($news->title);
            
            // Make slug unique
            $originalSlug = $slug;
            $count = 1;
            
            while (DB::table('news')->where('slug', $slug)->where('id', '!=', $news->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            
            DB::table('news')
                ->where('id', $news->id)
                ->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        // No need to revert
    }
};