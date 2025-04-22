<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatLngToSocialPostsTable extends Migration
{
    public function up()
    {
        Schema::table('social_posts', function (Blueprint $table) {
            $table->decimal('lat', 10, 7)->nullable()->after('address');
            $table->decimal('lng', 10, 7)->nullable()->after('lat');
        });
    }

    public function down()
    {
        Schema::table('social_posts', function (Blueprint $table) {
            $table->dropColumn(['lat', 'lng']);
        });
    }
}
