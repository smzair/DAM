<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Uploadraw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('uploadraw',function (Blueprint $table){
          $table->increments('id');
            $table->integer('sku_id');
            $table->string('filename');
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
    
    Schema::dropIfExists('uploadraw');
    }
}

