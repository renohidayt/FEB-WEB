<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nim')->unique(); // NIM sebagai username
            $table->string('nik')->nullable(); // NIK
            $table->string('nama');
            $table->string('program_studi');
            $table->date('tanggal_masuk');
            $table->enum('status', ['AKTIF', 'CUTI', 'LULUS', 'KELUAR'])->default('AKTIF');
            $table->enum('jenis', ['Peserta didik baru', 'Peserta didik pindahan'])->default('Peserta didik baru');
            $table->decimal('biaya_masuk', 12, 2)->nullable();
            $table->enum('jenis_kelamin', ['P', 'L']); // P = Perempuan, L = Laki-laki
            $table->date('tempat_tanggal_lahir')->nullable(); // Tanggal lahir untuk password
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])->nullable();
            $table->text('alamat')->nullable();
            $table->enum('status_sync', ['Sudah Sync', 'Belum Sync'])->default('Belum Sync');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};