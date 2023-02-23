<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Allocations extends Migration

{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('allocation',function (Blueprint $table){
          $table->increments('id');
            $table->integer('uploadraw_id');
            $table->string('user_id');
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
            Schema::dropIfExists('allocation');

    }
}
