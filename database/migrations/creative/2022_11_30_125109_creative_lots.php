<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreativeLots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
      {
     Schema::create('creative_lots',function (Blueprint $table){
        $table->increments('id');
         $table->integer('user_id')->unsigned();
        $table->integer('brand_id')->unsigned();
        $table->string('lot_number')->nullable();
        $table->string('project_type');
         $table->string('verticle');
                  $table->string('client_bucket');
        $table->date('work_initiate_date');
        $table->date('Comitted_initiate_date');
        $table->string('status');
        $table->timestamps();
    });

     Schema::table('creative_lots', function (Blueprint $table) {
        $table->foreign('brand_id')->references('id')->on('brands')

        ->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')

        ->onDelete('cascade');

    });
}
}
