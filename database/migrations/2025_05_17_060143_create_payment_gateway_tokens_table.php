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
        Schema::create('payment_gateway_tokens', function (Blueprint $table) {
            $table->id();
             $table->foreignId('club_id')->nullable()->constrained('clubs')->onDelete('set null');
            $table->foreignId('payment_gateway_id')->constrained('payment_gateways')->onDelete('cascade');
            $table->string('snapToken');
            $table->string('order_id')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_tokens');
    }
};
