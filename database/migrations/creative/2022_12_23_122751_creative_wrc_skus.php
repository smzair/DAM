<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreativeWrcSkus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creative_wrc_skus',function (Blueprint $table){
            $table->increments('id');
            $table->string('sku_code');
            $table->string('project_name');
            $table->string('kind_of_work');
            $table->integer('wrc_id')->nullable();
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
        Schema::dropIfExists('creative_wrc_skus');
    }
}
