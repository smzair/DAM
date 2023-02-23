<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CatalogUploadLink extends Migration
{
    public function up()
    {
        Schema::create('catalog_upload_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('allocation_id');
            $table->string('catalog_link');
            $table->string('copy_link');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('catalog_upload_links');
    }
}
