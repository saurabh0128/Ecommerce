<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->nullable();
            $table->string('coupon_code',40);
            $table->text('coupon_details');
            $table->decimal('coupon_discount',8,2);
            $table->string('coupon_type',20);
            $table->string('discount_type',20);
            $table->unsignedInteger('total_uses')->nullable()->change();
            $table->integer('coupon_type_value');
            $table->date('start_date');
            $table->date('end_date');
            
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
        Schema::dropIfExists('coupons');
    }
}
