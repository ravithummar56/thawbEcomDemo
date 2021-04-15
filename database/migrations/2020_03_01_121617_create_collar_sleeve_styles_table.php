<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollarSleeveStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collar_sleeve_styles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('image');
            $table->string('title');
            $table->unsignedBigInteger('kandora_style_id');
            $table->foreign('kandora_style_id')->references('id')->on('kandora_styles')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('collar_sleeve_styles');
    }
}
