<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Wrc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('wrc',function (Blueprint $table){
        $table->increments('id');
        $table->integer('lot_id')->unsigned();
        $table->string('wrc_id');
        $table->string('commercial_id');
        $table->string('status');
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
        Schema::dropIfExists('wrc');
    }
}
