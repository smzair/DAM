<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogWrcSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('catalog_wrc_skus', function (Blueprint $table) {
            $table->id();
            $table->string('sku_code')->nullable();
            $table->string('style')->nullable();
            $table->string('type_of_service')->nullable();
            $table->integer('wrc_id');
            $table->integer('batch_no');
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
        Schema::dropIfExists('catalog_wrc_skus');
    }
}
