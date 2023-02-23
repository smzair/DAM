<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreativeWrcs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('creative_wrc',function (Blueprint $table){
        $table->increments('id');
        $table->integer('lot_id')->unsigned();
        $table->string('wrc_number');
        $table->string('commercial_id');
        $table->string('order_qty');
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
        Schema::dropIfExists('creative_wrc');
    }
}
