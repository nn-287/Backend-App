<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->insert([
            /*
            'id' => 14, // Replace with the desired ID
            'first_name' => 'p',
            'second_name' => 'k',
            'email' => 'pk@example.com',
            'phone_number'=>'01207940010',
            'password' => bcrypt('password'), // You can use the bcrypt function to hash the password
            */
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
