<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToDailyRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_registration', function (Blueprint $table) {
            $table->string('merchant_id')->nullable()->default(env('MERCHANT_ID', '')); // Default merchant_id
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_registration', function (Blueprint $table) {
            $table->dropColumn([
                'merchant_id',
                'merchant_key',
                'return_url',
                'cancel_url',
                'notify_url',
                'name_first',
                'name_last',
                'email_address',
                'cell_number',
                'm_payment_id',
                'custom_int1',
                'custom_str1',
                'email_confirmation',
                'confirmation_address',
                'payment_method',
                'amount',
                'item_name',
                'item_description',
                'payment_status',
            ]);
        });
    }
}
