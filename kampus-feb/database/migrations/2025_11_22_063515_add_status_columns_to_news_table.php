<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {

            // Tambahkan show_on_homepage jika belum ada
            if (!Schema::hasColumn('news', 'show_on_homepage')) {
                $table->boolean('show_on_homepage')
                      ->default(false)
                      ->after('category_id');
            }

            // Tambahkan is_published jika belum ada
            if (!Schema::hasColumn('news', 'is_published')) {
                $table->boolean('is_published')
                      ->default(false)
                      ->after('show_on_homepage');
            }
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {

            if (Schema::hasColumn('news', 'show_on_homepage')) {
                $table->dropColumn('show_on_homepage');
            }

            if (Schema::hasColumn('news', 'is_published')) {
                $table->dropColumn('is_published');
            }
        });
    }
};
