<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAudienceToEventsTable extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            // Adding the audience column
            $table->enum('audience', ['internal', 'public'])->default('internal');
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            // Dropping the audience column if needed
            $table->dropColumn('audience');
        });
    }
}
