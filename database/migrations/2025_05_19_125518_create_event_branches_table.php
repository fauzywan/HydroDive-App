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
        Schema::create('event_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_number_id')->constrained('event_numbers')->cascadeOnDelete();
            $table->string('name');
            $table->foreignId('group_age_id')->constrained()->cascadeOnDelete();
            $table->integer('capacity')->default(0);
            $table->integer('current_capacity')->default(0);
            $table->integer('capacity_per_club')->default(0);
            $table->integer('registration_fee');
            $table->boolean('is_relay')->default(1);
            $table->integer('line');
            $table->tinyInteger('is_final')->nullabel()->default(1);
            $table->string('description')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_branches');
    }
};
