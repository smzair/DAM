<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DayPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          
        Schema::create('dayplan',function (Blueprint $table){
            $table->increments('id');
            $table->integer('plan_date');
            $table->integer('studio');
            $table->integer('photographer');
            $table->integer('stylist');
            $table->string('makeupartist');
            $table->string('rawqc');
            $table->string('model');
            $table->string('agengy');
            $table->string('assistant');
            $table->timestamps();
        });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    
    Schema::dropIfExists('dayplan');
    }
}
