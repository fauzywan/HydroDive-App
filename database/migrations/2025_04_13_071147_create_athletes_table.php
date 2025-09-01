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
        Schema::create('athletes', function (Blueprint $table) {
            $table->id();
            $table->string('nation');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->char('identity_number', 16)->unique();
            $table->date('dob');
            $table->enum('gender',['male','female']);
            $table->string('province');
            $table->string('city');
            $table->string("address");
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('school');
            $table->string('photo');
            $table->string('type');
            $table->foreignId('club_id')
            ->nullable()
            ->constrained('clubs')
            ->onDelete('set null');
            $table->boolean('status');
            $table->boolean('is_deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('athletes');
    }
};
