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
            $table->string('status')->default('show'); // You can choose the default value
        });
        Schema::table('social_posts', function (Blueprint $table) {
            $table->string('status')->default('show'); // You can choose the default value
        });
    }
    
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('social_posts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
    
};
