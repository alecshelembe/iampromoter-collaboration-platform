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
        Schema::table('posts', function (Blueprint $table) {
            // Change description column to TEXT
            $table->text('description')->change();
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Revert description column back to string if needed
            $table->string('description', 255)->change();
        });
    }

};
