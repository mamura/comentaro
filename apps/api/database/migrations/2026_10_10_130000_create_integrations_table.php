<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integrations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->string('provider', 40);
            $table->string('status', 40);
            $table->string('requested_identifier_type', 20);
            $table->string('requested_identifier', 64);
            $table->string('merchant_id', 64)->nullable()->unique();
            $table->unsignedSmallInteger('sync_interval_minutes')->default(60);
            $table->timestamps();
            $table->unique(['location_id', 'provider']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integrations');
    }
};
