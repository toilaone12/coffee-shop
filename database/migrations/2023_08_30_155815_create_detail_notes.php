<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_notes', function (Blueprint $table) {
            $table->increments('id_detail');
            $table->integer('id_note');
            $table->integer('id_unit');
            $table->string('code_note',6);
            $table->string('name_ingredient',255);
            $table->integer('quantity_ingredient');
            $table->integer('price_ingredient');
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
        Schema::dropIfExists('detail_notes');
    }
}
