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
        Schema::create('event_match_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_match_id')->constrained('event_matches')->cascadeOnDelete();
        $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('administration_id')->nullable()->constrained('event_administrations')->nullOnDelete();
            $table->foreignId('athlete_id')->nullable()->constrained('athletes')->nullOnDelete();
            $table->foreignId('club_id')->nullable()->constrained('clubs')->nullOnDelete();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('status')->default(0);
            $table->time('result_time')->nullable();
            $table->integer('rank')->nullable();
            $table->integer('line')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_match_players');
    }
};
