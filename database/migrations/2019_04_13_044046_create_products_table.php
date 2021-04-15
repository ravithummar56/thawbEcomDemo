<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug');
            $table->double('manufacturing_price',15,2);
            $table->double('price',15,2);
            $table->double('sell_price',15,2);
            $table->integer('quantity');
            $table->enum('gender',['male','female']);
            $table->enum('type',['kuwaiti','emirati','saudi'])->nullable();
            $table->enum('status',['active','deactive'])->default('active');
            $table->enum('product_type',['main_product','finish_product']);
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
        Schema::dropIfExists('products');
    }
}
