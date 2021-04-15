<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('pincode')->nullable();
            $table->text('address')->nullable();
            $table->text('lat')->nullable();;
            $table->text('long')->nullable();;
            $table->string('state')->nullable();;
            $table->string('country')->nullable();;
            $table->enum('type',['billing','shipping'])->default('shipping');
            $table->enum('default',['yes','no'])->default('no');
            $table->enum('action',['active','deactive'])->default('active');
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
        Schema::dropIfExists('customer_addresses');
    }
}
