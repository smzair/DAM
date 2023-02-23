<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditingAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editing_allocations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wrc_id')->unsigned();
            $table->integer('allocated_qty')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('user_role')->default(0)->comment('0 for Editor');
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
        Schema::dropIfExists('editing_allocations');
    }
}
