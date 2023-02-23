<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Brands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('short_name')->unique();
            $table->timestamps();
        });


        Schema::create('brands_user', function (Blueprint $table) {
            $table->Integer('user_id')->unsigned();
            $table->Integer('brand_id')->unsigned();
            $table->timestamps();

        });
            Schema::table('brands_user', function (Blueprint $table) {
                $table->foreign('brand_id')->references('id')->on('brands')

            ->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')

            ->onDelete('cascade');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
     Schema::dropIfExists('brands');
        Schema::dropIfExists('brand_user');
    
    }
}

