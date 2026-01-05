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
            $table->string('name'); // Nama Beasiswa
            $table->enum('type', [
                'prestasi',
                'kip-k',
                'pemerintah',
                'internal',
                'swasta',
                'tahfidz',
                'penelitian'
            ]); // Jenis Beasiswa
            $table->enum('category', [
                'pemerintah',
                'internal',
                'prestasi',
                'bantuan_ukt',
                'swasta',
                'tahfidz',
                'penelitian'
            ]); // Kategori untuk website
            $table->decimal('amount', 15, 2)->nullable(); // Nominal
            $table->string('poster')->nullable(); // Banner/Poster
            $table->text('description'); // Deskripsi
            $table->text('requirements'); // Persyaratan
            $table->string('provider')->nullable(); // Pemberi beasiswa
            $table->string('contact_person')->nullable(); // CP
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('website_url')->nullable(); // Link pendaftaran
            $table->date('registration_start')->nullable();
            $table->date('registration_end')->nullable();
            $table->date('announcement_date')->nullable();
            $table->integer('quota')->nullable(); // Kuota
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false); // Tampil di homepage
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};