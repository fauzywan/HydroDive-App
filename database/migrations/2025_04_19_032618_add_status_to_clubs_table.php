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
        Schema::table('clubs', function (Blueprint $table) {
            $table->boolean('status');
            $table->string('logo');
            $table->string('number_of_members');
            $table->string("email")->unique();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('number_of_members');
            $table->dropColumn('email');
            $table->dropColumn('logo');
        });
    }
};
