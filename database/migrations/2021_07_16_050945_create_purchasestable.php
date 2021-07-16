<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasestable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade');
            $table->string('customer_name',50);
            $table->foreignId('user_address_id')->constrained('user_addresses')->onUpdate('cascade');
            $table->foreignId('billing_address_id')->constrained('user_addresses')->onUpdate('cascade');
            $table->foreignId('coupon_id')->constrained('coupons')->onUpdate('cascade');
            $table->decimal('shipping_amt',8,2);
            $table->decimal('total_amt',8,2);
            $table->tinyInteger('is_payed');
            $table->string('payment_mode',30);
            $table->string('transaction_no',30);
            $table->date('purchase_date');
            $table->date('delivery_date');
            $table->string('delivery_status',100);
            $table->string('purchase_status',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
