<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade');
            $table->foreignId('purchase_id')->constrained('purchases')->onUpdate('cascade');
            $table->decimal('payable_amt',8,2);
            $table->decimal('chargable_amt',8,2);
            $table->tinyInteger('is_payed');
            $table->string('payment_mode',30);
            $table->string('transaction_no',30);
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
        Schema::dropIfExists('seller_payments');
    }
}
