<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('make_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->unsignedBigInteger('user_sizes_id')->nullable();
            $table->foreign('user_sizes_id')->references('id')->on('user_sizes')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('fabric_id');
            $table->foreign('fabric_id')->references('id')->on('fabrics')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('kandora_style_id')->nullable();
            $table->foreign('kandora_style_id')->references('id')->on('kandora_styles')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('collar_style_id')->nullable();
            $table->foreign('collar_style_id')->references('id')->on('collar_sleeve_styles')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('gender',['male','female'])->nullable();
            $table->enum('sleeve_style',['yes','no'])->nullable();
            $table->enum('request_trailer',['yes','no'])->default('no');
            $table->double('price',20,2);
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
        Schema::dropIfExists('make_products');
    }
}
