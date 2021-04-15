<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->bigInteger('phone_number')->nullable();
            $table->string('password')->nullable();
            $table->enum('role_id',['1','2'])->comment('1= admin 2= user');
            $table->string('device_token')->unique()->nullable();
            $table->string('device_id')->nullable();
            $table->enum('device_type',['android','ios'])->nullable();
            $table->enum('phone_verify',['true','false'])->default('false');
            $table->enum('social_type',['facebook','google','linkdin'])->nullable();
            $table->string('social_id')->unique()->nullable();
            $table->string('profile_picture')->nullable();            
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
        Schema::dropIfExists('users');
    }
}
