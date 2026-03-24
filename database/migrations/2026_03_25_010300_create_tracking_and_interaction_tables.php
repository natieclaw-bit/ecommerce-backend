<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracking_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_key')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('device_fingerprint')->nullable();
            $table->string('origin_channel')->nullable();
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'last_activity_at']);
        });

        Schema::create('interaction_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('tracking_session_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event_type');
            $table->string('origin_channel')->nullable();
            $table->json('payload')->nullable();
            $table->timestamp('occurred_at')->useCurrent();
            $table->timestamps();
            $table->index(['event_type', 'occurred_at']);
            $table->index(['user_id', 'occurred_at']);
        });

        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('tracking_session_id')->nullable()->constrained()->nullOnDelete();
            $table->string('query_text');
            $table->json('filters')->nullable();
            $table->unsignedInteger('result_count')->default(0);
            $table->string('clicked_sku')->nullable();
            $table->unsignedInteger('latency_ms')->nullable();
            $table->timestamp('occurred_at')->useCurrent();
            $table->timestamps();
            $table->index(['query_text']);
            $table->index(['occurred_at']);
        });

        Schema::create('recommendation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('tracking_session_id')->nullable()->constrained()->nullOnDelete();
            $table->string('algorithm_version')->nullable();
            $table->json('context')->nullable();
            $table->json('served_skus');
            $table->json('engagement')->nullable();
            $table->string('feedback_status')->default('pending');
            $table->timestamp('served_at')->useCurrent();
            $table->timestamps();
            $table->index(['user_id', 'served_at']);
            $table->index(['feedback_status']);
        });

        Schema::create('cart_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('tracking_session_id')->nullable()->constrained()->nullOnDelete();
            $table->string('snapshot_hash')->unique();
            $table->json('items');
            $table->decimal('subtotal', 10, 2);
            $table->timestamp('captured_at')->useCurrent();
            $table->timestamps();
            $table->index(['user_id', 'captured_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_snapshots');
        Schema::dropIfExists('recommendation_logs');
        Schema::dropIfExists('search_logs');
        Schema::dropIfExists('interaction_events');
        Schema::dropIfExists('tracking_sessions');
    }
};
