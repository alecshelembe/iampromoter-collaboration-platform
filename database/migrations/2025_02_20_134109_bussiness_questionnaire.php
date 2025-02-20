<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('business_questionnaires', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('industry');
            $table->string('website')->nullable();
            $table->string('social_media')->nullable();
            $table->string('contact_person');
            $table->string('email');
            $table->string('phone');
            $table->json('campaign_goals');
            $table->text('brand_story')->nullable();
            $table->string('influencer_size');
            $table->string('budget')->nullable();
            $table->string('campaign_type');
            $table->text('brand_guidelines')->nullable();
            $table->text('success_metrics')->nullable();
            $table->text('ref')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_questionnaires');
    }
};
