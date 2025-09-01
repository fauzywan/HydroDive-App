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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->nullable()->constrained('clubs')->onDelete('set null');
            $table->string('name');
            $table->datetime('competition_start');
            $table->datetime('competition_end')->nullable();
            $table->string('location');
            $table->tinyInteger('is_limited')->nullable();
            $table->boolean('status')->default(0);
            $table->string('poster')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
