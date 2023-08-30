<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_notes', function (Blueprint $table) {
            $table->increments('id_notes');
            $table->integer('id_supplier');
            $table->string('code_notes',6);
            $table->integer('quantity_notes');
            $table->integer('status_notes');
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
        Schema::dropIfExists('import_notes');
    }
}
