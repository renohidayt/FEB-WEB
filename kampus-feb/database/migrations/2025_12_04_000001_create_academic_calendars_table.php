<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_calendars', function (Blueprint $table) {
            $table->id();
            $table->string('academic_year'); // 2024/2025
            $table->enum('semester', ['ganjil', 'genap']); // Ganjil/Genap
            $table->string('event_name');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('event_type', ['perkuliahan', 'ujian', 'libur', 'wisuda', 'registrasi', 'lainnya'])->default('lainnya');
            $table->string('color', 7)->default('#3B82F6'); // Hex color
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_calendars');
    }
};
