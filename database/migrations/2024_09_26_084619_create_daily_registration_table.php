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
        Schema::create('daily_registration', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('email');
            $table->timestamp('login_time');
            $table->foreign('email')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_registration');
    }
};
