<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CatalogTimeHash extends Migration
{
    public function up()
    {
        Schema::create('catalog_time_hash', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('allocation_id');
            $table->dateTime('start_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('end_time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('catalog_time_hash');
    }
}
