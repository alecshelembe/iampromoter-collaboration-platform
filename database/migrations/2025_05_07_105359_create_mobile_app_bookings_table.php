<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileAppBookingsTable extends Migration
{
    public function up(): void
    {
        Schema::create('mobile_app_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->index();
            $table->string('notes')->nullable();
            $table->dateTime('datetime');
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobile_app_bookings');
    }
}
