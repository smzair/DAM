<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditingWrcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editing_wrcs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lot_id')->unsigned();
            $table->integer('commercial_id')->unsigned();
            $table->string('wrc_number');
            $table->integer('imgQty')->unsigned();
            $table->boolean('documentType')->default(0)->comment('0 for Link, 1 for SKU Sheet');
            $table->string('documentUrl');
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
        Schema::dropIfExists('editing_wrcs');
    }
}
