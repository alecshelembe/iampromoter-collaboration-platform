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
            $table->string('m_payment_id')->nullable();
            $table->string('pf_payment_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('item_name')->nullable();
            $table->string('item_description')->nullable();
            $table->decimal('amount_gross', 10, 2)->nullable();
            $table->decimal('amount_fee', 10, 2)->nullable();
            $table->decimal('amount_net', 10, 2)->nullable();
            $table->string('custom_str1')->nullable();
            $table->string('custom_str2')->nullable();
            $table->string('custom_str3')->nullable();
            $table->string('custom_str4')->nullable();
            $table->string('custom_str5')->nullable();
            $table->integer('custom_int1')->nullable();
            $table->integer('custom_int2')->nullable();
            $table->integer('custom_int3')->nullable();
            $table->integer('custom_int4')->nullable();
            $table->integer('custom_int5')->nullable();
            $table->string('name_first')->nullable();
            $table->string('name_last')->nullable(); // Added last name
            $table->string('email_address')->nullable();
            $table->string('merchant_id')->nullable();
            $table->string('signature')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payfast_transactions');
    }
}
