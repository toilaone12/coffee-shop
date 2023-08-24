<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id_product');
            $table->integer('id_category');
            $table->text('image_product');
            $table->string('name_product',255);
            $table->string('subname_product',255);
            $table->integer('quantity_product');
            $table->integer('quantity_sold_product');
            $table->integer('price_product');
            $table->text('description_product',255);
            $table->integer('number_reviews_product');
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
        Schema::dropIfExists('product');
    }
}
