<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CatlogWrc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catlog_wrc',function (Blueprint $table){
            $table->increments('id');
            $table->integer('lot_id')->unsigned();
            $table->string('wrc_number');
            $table->string('commercial_id');
            $table->string('status');
            $table->date('img_recevied_date');
            $table->date('missing_info_notify_date');
            $table->date('missing_info_recived_date');
            $table->date('confirmation_date');
            $table->string('work_brief');
            $table->string('guidelines');
            $table->string('document1');
            $table->string('document2');
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
        Schema::dropIfExists('catlog_wrc');
    }
}
