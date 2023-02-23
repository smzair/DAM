<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditorSubmmision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('editor_submission',function (Blueprint $table){
            $table->increments('id');
            $table->integer('sku_id');
            $table->string('filename');
            $table->integer('qc');
            $table->string('adaptation');
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
        Schema::dropIfExists('editor_submission');    
    }
}
