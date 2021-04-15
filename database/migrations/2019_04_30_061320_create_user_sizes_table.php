<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->double('sleeves',15,2)->nullable();
            $table->double('bust',15,2)->nullable();
            $table->double('hips',15,2)->nullable();
            $table->double('length',15,2)->nullable();
            $table->double('lower_sleeve',15,2)->nullable();
            $table->double('neck',15,2)->nullable();
            $table->double('shoulder_width',15,2)->nullable();
            $table->text('comment')->nullable();
            $table->string('dimension_type')->nullable();
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
        Schema::dropIfExists('user_sizes');
    }
}
