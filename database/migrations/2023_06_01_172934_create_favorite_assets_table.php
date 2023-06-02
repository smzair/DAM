<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoriteAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('brand_id')->unsigned()->nullable();
            $table->integer('lot_id')->unsigned();
            $table->integer('wrc_id')->unsigned();
            $table->enum('service',['SHOOT','EDITING','CATALOGING','CREATIVE'])->default('SHOOT');
            $table->string('module');
            $table->enum('type', ['Raw', 'Edited'])->nullable();
            $table->integer('other_data_id')->nullable()->comment('commercial_id or sku id');
            $table->json('other_data')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
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
        Schema::dropIfExists('favorite_assets');
    }
}
