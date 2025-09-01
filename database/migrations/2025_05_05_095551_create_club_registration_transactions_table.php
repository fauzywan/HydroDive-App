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
        Schema::create('club_registration_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_registration_fee_id')->nullable()->constrained('club_registration_fees')->onDelete('set null');
            $table->integer('amount');
            $table->date('pay_time');
            $table->string('photo');
            $table->boolean('status')->default(1);
            $table->string('desc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_registration_transactions');
    }
};
