<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSellerinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seller_infos',function(Blueprint $table){
            $table->string('gst_no',30)->change();
            $table->string('ifsc_code',20)->change();
        });

        Schema::table('states',function(Blueprint $table){
            $table->renameColumn('create_at','created_at');
        });

        Schema::table('citys',function(Blueprint $table){
            $table->renameColumn('create_at','created_at');
        });

        Schema::table('categorys',function(Blueprint $table){
            $table->renameColumn('create_at','created_at');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
