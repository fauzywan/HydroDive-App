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
        Schema::create('event_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('heat_id')->constrained('event_heats')->cascadeOnDelete();
            $table->string('name');
            $table->integer('heat')->default(1);
            $table->datetime('start_time');
            $table->datetime('end_time')->nullable();
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_matches');
    }
};
