<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('daily_registration', function (Blueprint $table) {
            // Add the email column as a string
            $table->string('email')->after('login_time'); // Adjust position if needed

            // Add the foreign key constraint referencing the email column in the users table
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('daily_registration', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['email']);

            // Drop the email column
            $table->dropColumn('email');
        });
    }
};
