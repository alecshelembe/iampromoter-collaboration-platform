<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('influencer')->default(false); // Adds a boolean column with a default value of false
            $table->string('instagram_handle')->nullable(); // Adds a boolean column with a default value of false
            $table->string('tiktok_handle')->nullable(); // Adds a boolean column with a default value of false
            $table->string('linkedin_handle')->nullable(); // Adds a boolean column with a default value of false
            $table->string('x_handle')->nullable(); // Adds a boolean column with a default value of false
            $table->string('youtube_handle')->nullable(); // Adds a boolean column with a default value of false
            $table->string('other_handle')->nullable(); // Adds a boolean column with a default value of false
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('influencer');
            $table->dropColumn('instagram_handle');
            $table->dropColumn('tiktok_handle');
            $table->dropColumn('linkedin_handle');
            $table->dropColumn('x_handle');
            $table->dropColumn('youtube_handle');
            $table->dropColumn('other_handle');
        });
    }
};
