<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Google OAuth fields
            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable()->unique()->after('id');
            }

            if (!Schema::hasColumn('users', 'google_token')) {
                $table->string('google_token')->nullable()->after('google_id');
            }

            if (!Schema::hasColumn('users', 'google_avatar')) {
                $table->string('google_avatar')->nullable()->after('google_token');
            }

            // Status Management
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->index()->after('password');
            }

            // Additional info
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('is_active');
            }

            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('phone');
            }

            // Soft deletes
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'google_id')) $table->dropColumn('google_id');
            if (Schema::hasColumn('users', 'google_token')) $table->dropColumn('google_token');
            if (Schema::hasColumn('users', 'google_avatar')) $table->dropColumn('google_avatar');
            if (Schema::hasColumn('users', 'is_active')) $table->dropColumn('is_active');
            if (Schema::hasColumn('users', 'phone')) $table->dropColumn('phone');
            if (Schema::hasColumn('users', 'last_login_at')) $table->dropColumn('last_login_at');

            // Soft delete
            if (Schema::hasColumn('users', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
