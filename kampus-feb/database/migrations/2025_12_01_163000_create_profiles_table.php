<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            // ✅ Tambah 'visi_misi' ke enum
            $table->enum('type', ['Dekan', 'kemahasiswaan', 'struktur', 'sarana', 'visi_misi'])->unique();
            $table->string('name')->nullable();
            $table->string('photo')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};