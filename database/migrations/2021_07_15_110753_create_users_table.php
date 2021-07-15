<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',40);
            $table->string('user_name',40);
            $table->string('phone_no',10);
            $table->string('email_id',40);
            $table->string('password',100);
            $table->string('profile_img',50);
            $table->foreignId('roll_id')->constrained('rolls');
            $table->tinyInteger('is_verified');
            $table->tinyInteger('is_block');
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
        Schema::dropIfExists('users');
    }
}
