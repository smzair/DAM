<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogUploadedMarketplaceCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_uploaded_marketplace_counts', function (Blueprint $table) {
            $table->id();
            $table->integer('marketplace_id');
            $table->integer('allocation_id');
            $table->integer('approved_Count');
            $table->integer('rejected_Count');
            $table->date('upload_date');
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
        Schema::dropIfExists('catalog_uploaded_marketplace_counts');
    }
}
