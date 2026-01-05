<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('letter_templates', function (Blueprint $table) {
            $table->boolean('requires_approval_signature')->default(false)->after('form_fields');
            $table->string('approval_title')->nullable()->after('requires_approval_signature');
            $table->string('approval_name')->nullable()->after('approval_title');
            $table->string('approval_nip')->nullable()->after('approval_name');
        });
    }

    public function down()
    {
        Schema::table('letter_templates', function (Blueprint $table) {
            $table->dropColumn([
                'requires_approval_signature',
                'approval_title',
                'approval_name',
                'approval_nip'
            ]);
        });
    }
};