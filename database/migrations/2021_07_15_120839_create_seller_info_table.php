<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade');
            $table->bigInteger('gst_no');
            $table->string('company_name',50);
            $table->text('address');
            $table->foreignId('city_id')->constrained('citys')->onUpdate('cascade');
            $table->string('bank_name',40);
            $table->string('account_no',30);
            $table->bigInteger('ifsc_code');
            $table->string('ac_holder_name',50);
            $table->bigInteger('id_proof_no');
            $table->string('id_proof',50);
            $table->tinyInteger('is_permisssion_sell');
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
        Schema::dropIfExists('seller_infos');
    }
}
