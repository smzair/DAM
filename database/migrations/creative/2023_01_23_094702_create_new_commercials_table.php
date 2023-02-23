<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewCommercialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_commercials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commCompanyId');
            $table->integer('commBrandId');
            $table->string('commClientID');
            $table->string('c_short');
            $table->string('short_name');
            $table->boolean('commshootcheck');
            $table->boolean('commcgcheck');
            $table->boolean('commcatcheck');
            $table->boolean('shootCheckIsDone')->default(0)->comment('0 for no need , 1 for Pending , 2 for Done');
            $table->boolean('cgCheckIsDone')->default(0)->comment('0 for no need , 1 for Pending , 2 for Done');
            $table->boolean('catCheckIsDone')->default(0)->comment('0 for no need , 1 for Pending , 2 for Done');
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
        Schema::dropIfExists('new_commercials');
    }
}
