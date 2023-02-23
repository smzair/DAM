<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FlipkartEditing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('flipkart_editing',function (Blueprint $table){
          $table->increments('id');
            $table->integer('lot_id');
            $table->integer('wrc_id');
            $table->integer('imageCount');
             $table->string('recivedFilename');
              $table->string('remarks');
               $table->string('sentFilename');
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
    
    Schema::dropIfExists('flipkart_editing');
    
    }
}
