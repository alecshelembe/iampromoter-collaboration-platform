<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToSocialPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_posts', function (Blueprint $table) {
            $table->integer('social_p')->default(1); // Add the 'social_p' column with default value of 1
            $table->string('place_name')->nullable(); 
            $table->string('floating_sectors_value')->nullable(); 
            $table->string('address')->nullable(); 
            $table->decimal('fee', 10, 2)->nullable()->default(env('AMOUNT', ''));
            $table->json('extras')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('social_posts', function (Blueprint $table) {
            $table->dropColumn('social_p'); // Remove the 'social_p' column if rolled back
            $table->dropColumn('place_name');
            $table->dropColumn('floating_sectors_value');
            $table->dropColumn('address');
            $table->dropColumn('fee');
            $table->dropColumn('extras');

        });
    }
}
