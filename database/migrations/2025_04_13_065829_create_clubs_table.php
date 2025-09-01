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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("nick");
            $table->string("owner");
            $table->string("owner_photo");
            $table->string("address");
            $table->unsignedBigInteger('hoc')->nullable();
            $table->string("homebase");
            $table->string("pool_status");
            $table->foreignId("type_id")->nullable()->constrained('club_types')->onDelete("set null");
            $table->string("notarial_deed");
            $table->string("registration_link");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
