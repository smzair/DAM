<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CatalogAllocation extends Migration
{
   
    public function up()
    {
        Schema::create('catalog_allocation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wrc_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('catalog_allocation');
    }
}
