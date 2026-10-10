<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interactions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('integration_id')->constrained()->cascadeOnDelete();
            $table->string('external_id', 100);
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestampTz('occurred_at');
            $table->string('priority', 20);
            $table->string('processing_status', 30)->default('received');
            $table->string('reply_status', 30)->default('not_replied');
            $table->string('provider_status', 40)->nullable();
            $table->string('visibility', 20)->nullable();
            $table->string('provider_version', 40)->nullable();
            $table->text('raw_payload')->nullable();
            $table->timestamps();
            $table->unique(['integration_id', 'external_id']);
            $table->index(['integration_id', 'occurred_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interactions');
    }
};
