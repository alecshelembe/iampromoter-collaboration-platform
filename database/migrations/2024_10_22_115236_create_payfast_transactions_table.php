<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayfastTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('payfast_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable(); $table->string('merchant_id')->nullable()->default(env('MERCHANT_ID', '')); // Default merchant_id
            $table->string('merchant_key')->nullable()->default(env('MERCHANT_KEY', '')); // Default merchant_key
            $table->string('return_url')->nullable()->default(env('RETURN_URL', ''));
            $table->string('cancel_url')->nullable()->default(env('CANCEL_URL', ''));
            $table->string('notify_url')->nullable()->default(env('NOTIFY_URL', ''));
            $table->string('name_first')->nullable();// Default first name
            $table->string('name_last')->nullable(); // Default last name
            $table->string('email_address')->nullable(); // Default email
            $table->string('cell_number')->nullable(); // Default cell number
            $table->string('m_payment_id')->nullable();
            $table->decimal('amount', 10, 2)->nullable()->default(env('AMOUNT', ''));
            $table->string('item_name')->nullable();
            $table->text('item_description')->nullable();
            $table->integer('custom_int1')->nullable();
            $table->string('custom_str1')->nullable();
            $table->boolean('email_confirmation')->default(env('EMAIL_CONFIRMATION', '')); // Default to confirmed
            $table->string('confirmation_address')->default(env('CONFIRMATION_ADDRESS', '')); // Default empty
            $table->text('payment_method')->nullable(env('PAYMENT_METHOD', ''));
            $table->string('payment_status')->default('No Action Taken');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payfast_transactions');
    }
}
