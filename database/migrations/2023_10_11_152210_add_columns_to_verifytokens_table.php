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
        Schema::table('verifytokens', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->string('email');
            $table->boolean('is_activated')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('verifytokens', function (Blueprint $table) {
            //
        });
    }
};
