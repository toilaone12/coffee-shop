<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->increments('id_customer');
            $table->text('image_customer');
            $table->string('name_customer',255);
            $table->tinyInteger('gentle_customer');
            $table->string('email_customer',255);
            $table->string('phone_customer',10);
            $table->text('password_customer');
            $table->tinyInteger('is_vip');
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
        Schema::dropIfExists('customer');
    }
}
