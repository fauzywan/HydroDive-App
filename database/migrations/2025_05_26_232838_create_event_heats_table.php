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
        Schema::create('event_heats', function (Blueprint $table) {
            $table->id();
              $table->foreignId('event_id')->constrained()->cascadeOnDelete();
              $table->foreignId('branch_id')->constrained('event_branches')->cascadeOnDelete();
              $table->string('name');
              $table->integer('heat_total');
              $table->integer('capacity')->default(0);
              $table->integer('best_of');
              $table->integer('from_rank');
              $table->integer('to_rank');
             $table->boolean('is_final');
             $table->boolean('is_sp');
             $table->integer('round');
             $table->boolean('status');
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_heats');
    }
};
