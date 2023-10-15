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
         // Add a new record to the users table and insert data
            DB::table('users')->insert([
                /*
                'id' => 18, // Replace with the desired ID
                'first_name' => 'Jojo',
                'second_name' => 'saturu',
                'email' => 'jojo@example.com',
                'phone_number'=>'9912',
                'password' => bcrypt('jojos'), // You can use the bcrypt function to hash the password
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
