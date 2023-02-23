<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CatalogQcCommentsTable extends Migration
{
    public function up()
    {
        Schema::create(
            'catalog_qc_comment',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('allocation_id');
                $table->text('comments')->nullable();
                $table->timestamps();
            }
        );
    }

    
    public function down()
    {
        Schema::dropIfExists('catalog_qc_comment');
    }
}
