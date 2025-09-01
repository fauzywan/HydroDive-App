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

        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('club_id')->unique()->comment('ID klub yang punya kredensial ini');
            $table->string('server_key', 255)->comment('Midtrans Server Key');
            $table->string('client_key', 255)->comment('Midtrans Client Key');
            $table->boolean('is_production')->default(false)->comment('Mode produksi atau sandbox');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
