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
        Schema::table('lecturers', function (Blueprint $table) {
            // Status Dosen
            $table->enum('employment_status', ['Tetap', 'Tidak Tetap'])->default('Tetap')->after('position');
            
            // Riwayat Pendidikan (JSON format untuk multiple entries)
            $table->text('education_s1')->nullable()->after('education_history');
            $table->text('education_s2')->nullable()->after('education_s1');
            $table->text('education_s3')->nullable()->after('education_s2');
            
            // Pengalaman Akademik
            $table->text('teaching_experience')->nullable()->after('courses_taught');
            $table->string('structural_position')->nullable()->after('teaching_experience');
            
            // Publikasi & Penelitian
            $table->text('publications')->nullable()->after('research_interests');
            $table->text('conference_papers')->nullable()->after('publications');
            $table->text('books_hki')->nullable()->after('conference_papers');
            
            // Pengabdian Masyarakat
            $table->text('community_service')->nullable()->after('books_hki');
            
            // Sertifikasi & Penghargaan
            $table->text('certifications')->nullable()->after('community_service');
            $table->text('awards')->nullable()->after('certifications');
            
            // Identitas Digital
            $table->string('google_scholar_url')->nullable()->after('email');
            $table->string('sinta_id')->nullable()->after('google_scholar_url');
            $table->string('scopus_id')->nullable()->after('sinta_id');
            $table->string('orcid')->nullable()->after('scopus_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lecturers', function (Blueprint $table) {
            $table->dropColumn([
                'employment_status',
                'education_s1',
                'education_s2',
                'education_s3',
                'teaching_experience',
                'structural_position',
                'publications',
                'conference_papers',
                'books_hki',
                'community_service',
                'certifications',
                'awards',
                'google_scholar_url',
                'sinta_id',
                'scopus_id',
                'orcid',
            ]);
        });
    }
};