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
        Schema::create('player_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('event_match_players')->cascadeOnDelete();
            $table->datetime('start_time')->nullable();
            $table->datetime('finish_time')->nullable();
            $table->time('duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_times');
    }
};
