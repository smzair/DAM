<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditingUploadLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editing_upload_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('allocation_id');
            $table->string('final_link');
            $table->boolean('task_status')->comment('0 for not completed, 1 for completed from user , 2 for submistion done');
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
        Schema::dropIfExists('editing_upload_links');
    }
}
