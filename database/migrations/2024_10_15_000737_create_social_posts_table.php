<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialPostsTable extends Migration
{
    public function up()
    {
        Schema::create('social_posts', function (Blueprint $table) {
            $table->id();
            $table->text('description'); // Description of the post
            $table->json('images')->nullable(); // Store image paths as a JSON array
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('social_posts');
    }
}
