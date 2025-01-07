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
            // Drop the foreign key constraint
            $table->dropForeign(['email']); // This will drop the foreign key constraint

            // Now drop the email column
            $table->dropColumn('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('daily_registration', function (Blueprint $table) {
            // Restore the email column
            $table->string('email');

            // Re-add the foreign key constraint if needed
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
        });
    }
};
