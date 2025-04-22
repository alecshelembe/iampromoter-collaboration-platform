<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->timestamp('location_recorded_at')->nullable();

            // Device info
            $table->string('device_id')->nullable();
            $table->string('device_name')->nullable();
            $table->string('platform')->nullable(); // 'ios' or 'android'
            $table->string('app_version')->nullable();
            $table->string('expo_push_token')->nullable();
            $table->timestamp('last_active_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_locations');
    }
};
