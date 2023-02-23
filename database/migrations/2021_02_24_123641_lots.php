<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Lots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('lots',function (Blueprint $table){
        $table->increments('id');
        $table->string('lot_id')->nullable();
        $table->integer('user_id')->unsigned();
        $table->integer('brand_id')->unsigned();
        $table->string('status');
        $table->timestamps();
    });

     Schema::table('lots', function (Blueprint $table) {
        $table->foreign('brand_id')->references('id')->on('brands')

        ->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')

        ->onDelete('cascade');

    });
 }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lots');
    }
}
