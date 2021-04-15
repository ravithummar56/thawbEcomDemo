<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->integer('fabric_id')->nullable();
            $table->integer('color_id')->nullable();
            $table->integer('size_id')->nullable();
            $table->integer('collar_style_id')->nullable();
            $table->integer('kandora_style_id')->nullable();
            $table->string('product_slug')->nullable();
            $table->string('fabric_name')->nullable();
            $table->string('color_name')->nullable();
            $table->string('size_name')->nullable();
            $table->integer('user_size_id')->nullable();
            $table->string('collar_style')->nullable();
            $table->string('kandora_style')->nullable();
            $table->enum('sleeve_style',['yes','no'])->nullable();
            $table->enum('gender',['male','female']);
            $table->enum('type',['kuwaiti','emirati','saudi'])->nullable();
            $table->enum('product_type',['main_product','finish_product','custome_product']);
            $table->double('manufacturing_price',15,2);
            $table->double('price',15,2);
            $table->double('sell_price',15,2);
            $table->integer('quantity');
            $table->double('total',15,2);
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
        Schema::dropIfExists('order_items');
    }
}
