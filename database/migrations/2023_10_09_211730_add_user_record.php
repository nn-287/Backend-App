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
            'id' => 15, // Replace with the desired ID
            'first_name' => 'q',
            'second_name' => 'a',
            'email' => 'qa@example.com',
            'phone_number'=>'01122',
            'password' => bcrypt('nancy'), 
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
