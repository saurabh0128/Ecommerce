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
            $table->foreignId('user_id')->constrained('users');
            $table->string('gst_no',20);
            $table->string('company_name',50);
            $table->text('address');
            $table->foreignId('city_id')->constrained('citys');
            $table->string('bank_name',40);
            $table->string('account_no',30);
            $table->string('ifsc_code',20);
            $table->string('ac_holder_name',50);
            $table->string('id_proof_no',40);
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
