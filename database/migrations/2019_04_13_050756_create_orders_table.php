<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('order_id');
            $table->string('order_name');
            $table->string('promo_code')->nullable();
            $table->string('order_email')->nullable();
            $table->string('order_phone_number');
            $table->integer('billing_address_id');
            $table->integer('shipping_address_id');
            $table->integer('order_status_id');
            $table->integer('payments_status_id');
            $table->enum('payments_type',['cod','payfort']);
            $table->enum('request_tailor',['true','false'])->defalut('false');
            $table->string('invoice_number');
            $table->date('orderDate');
            $table->double('subtotal',15,2);
            $table->double('shipping_charge',15,2);
            $table->double('extra_charg',15,2);
            $table->double('tax_value',15,2);
            $table->double('total',15,2);
            $table->string('extra_note')->nullable();
            $table->string('tag_name')->nullable();
            $table->date('delivered_date')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
