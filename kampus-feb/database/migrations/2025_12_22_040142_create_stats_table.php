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
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // mahasiswa, dosen, prodi, alumni, dll
            $table->string('label'); // Label untuk ditampilkan
            $table->integer('value')->default(0); // Angka statistik
            $table->string('icon')->nullable(); // Icon FontAwesome (fa-users, fa-chalkboard-teacher, dll)
            $table->string('color')->default('blue'); // Warna: blue, green, orange, red, purple
            $table->integer('order')->default(0); // Urutan tampilan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};