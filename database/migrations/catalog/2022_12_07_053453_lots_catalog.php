<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LotsCatalog extends Migration
{
    public function up()
    {
        Schema::create('lots_catalog', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->string('serviceType');
            $table->string('requestType');
            $table->date('reqReceviedDate');
            $table->date('imgReceviedDate');
            $table->timestamps();
        });

        Schema::table('creative_lots', function (Blueprint $table) {
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
