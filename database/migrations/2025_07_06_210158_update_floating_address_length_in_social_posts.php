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
        Schema::table('social_posts', function (Blueprint $table) {
            $table->string('floating_sectors_value', 500)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('social_posts', function (Blueprint $table) {
            $table->string('floating_sectors_value', 255)->change();
        });
    }

};
