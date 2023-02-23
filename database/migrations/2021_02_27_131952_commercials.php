<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Commercials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial',function (Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->string('product_category');
            $table->string('type_of_shoot');
            $table->string('type_of_clothing');
            $table->string('gender');
            $table->string('adaptation_1');
            $table->string('adaptation_2');
            $table->string('adaptation_3');
            $table->string('adaptation_4');
            $table->string('adaptation_5');
            $table->integer('commercial_value_per_sku');
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
        Schema::dropIfExists('commercial');
    }
}
