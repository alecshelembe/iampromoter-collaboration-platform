<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToSocialPostsTable extends Migration
{
    public function up()
    {
        Schema::table('social_posts', function (Blueprint $table) {
            $table->string('email')->after('description'); // Add the email column
        });
    }

    public function down()
    {
        Schema::table('social_posts', function (Blueprint $table) {
            $table->dropColumn('email'); // Drop the email column if rolling back
        });
    }
}
