<?php
// database/migrations/2024_01_15_create_organizational_structures_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizational_structures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position'); // Jabatan
            $table->string('nip')->nullable(); // Nomor Induk Pegawai
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable(); // Self-referencing
            $table->integer('order')->default(0); // Urutan tampil
            $table->enum('type', ['structural', 'academic', 'administrative'])->default('structural');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Foreign key ke diri sendiri
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('organizational_structures')
                  ->onDelete('cascade');
            
            // Index untuk performance
            $table->index('parent_id');
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizational_structures');
    }
};

