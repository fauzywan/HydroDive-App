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
        Schema::create('athlete_migration_clubs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_id')->nullable()->constrained('athletes')->onDelete('set null');
            $table->foreignId('new_club')->nullable()->constrained('clubs')->onDelete('set null');
            $table->foreignId('old_club')->nullable()->constrained('clubs')->onDelete('set null');
            $table->foreignId('approver_1')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approver_2')->nullable()->constrained('users')->onDelete('set null');
            $table->date('date_approve_1')->nullable();
            $table->date('date_approve_2')->nullable();
            $table->date('date_request');
            $table->text('reason');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('athlete_migration_clubs');
    }
};
