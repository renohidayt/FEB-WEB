<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE scholarships 
            MODIFY type ENUM(
                'prestasi',
                'kip-k',
                'pemerintah',
                'internal',
                'swasta',
                'tahfidz',
                'penelitian',
                'bantuan_sosial'
            )
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE scholarships 
            MODIFY type ENUM(
                'prestasi',
                'kip-k',
                'pemerintah',
                'internal',
                'swasta',
                'tahfidz',
                'penelitian'
            )
        ");
    }
};

