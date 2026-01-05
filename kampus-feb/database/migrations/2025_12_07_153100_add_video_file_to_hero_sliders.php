<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_sliders', function (Blueprint $table) {
            // 1. Tambahkan kolom 'video_file' (yang kamu buat)
            if (!Schema::hasColumn('hero_sliders', 'video_file')) {
                $table->string('video_file')->nullable()->after('media_path');
            }

            // 2. Tambahkan kolom 'tagline' (Dibutuhkan untuk UI baru)
            if (!Schema::hasColumn('hero_sliders', 'tagline')) {
                $table->string('tagline')->nullable()->after('subtitle');
            }

            // 3. FIX ERROR: Ubah kolom button menjadi Boleh Kosong (Nullable)
            // Ini solusi untuk error "Column 'button_text' cannot be null"
            $table->string('button_text')->nullable()->change();
            $table->string('button_link')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('hero_sliders', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $table->dropColumn(['video_file', 'tagline']);
            
            // Kembalikan button jadi wajib isi (Not Null)
            // Note: Hati-hati saat rollback jika ada data null
            $table->string('button_text')->nullable(false)->change();
            $table->string('button_link')->nullable(false)->change();
        });
    }
};