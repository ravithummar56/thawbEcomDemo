<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFabricColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fabric_colors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('fabric_id');
            $table->foreign('fabric_id')->references('id')->on('fabrics')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('fabric_colors');
    }
}
