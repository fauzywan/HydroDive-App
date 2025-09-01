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
        Schema::create('event_administrations', function (Blueprint $table) {
            $table->id();
             $table->foreignId('event_id')->constrained()->cascadeOnDelete();
             $table->foreignId('event_branch_id')->constrained()->cascadeOnDelete();
             $table->foreignId('club_id')->constrained()->cascadeOnDelete();
             $table->foreignId('athlete_id')->constrained()->cascadeOnDelete();
             $table->integer('fee');
             $table->integer('rank')->default(0);
             $table->boolean('status')->default(1);
             $table->boolean('status_fee')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_administrations');
    }
};
