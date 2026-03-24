<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('preferred_channel')->nullable()->after('remember_token');
            $table->string('lifecycle_stage')->default('new')->after('preferred_channel');
            $table->timestamp('last_engagement_at')->nullable()->after('lifecycle_stage');
            $table->json('cx_tags')->nullable()->after('last_engagement_at');
            $table->index(['lifecycle_stage', 'preferred_channel']);
            $table->index('last_engagement_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_lifecycle_stage_preferred_channel_index');
            $table->dropIndex('users_last_engagement_at_index');
            $table->dropColumn(['preferred_channel', 'lifecycle_stage', 'last_engagement_at', 'cx_tags']);
        });
    }
};
