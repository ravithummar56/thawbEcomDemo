<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFabricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fabrics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fabric_name');
            $table->text('fabric_description_en')->nullable();
            $table->text('fabric_description_es')->nullable();
            $table->string('image');
            $table->string('male')->nullable();
            $table->string('female')->nullable();
            $table->enum('status',['active','deactive'])->default('active');
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
        Schema::dropIfExists('fabrics');
    }
}
