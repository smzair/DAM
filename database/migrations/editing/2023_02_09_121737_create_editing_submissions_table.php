<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditingSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editing_submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wrc_id')->unsigned();
            $table->date('submission_date');
            $table->boolean('ar_status')->default(0)->comment('0 for pending , 1 for approvad by client , 2 for rejected ');
            $table->string('rejection_reason',100);
            $table->dateTime('action_date')->default('0000-00-00 00:00:00');
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
        Schema::dropIfExists('editing_submissions');
    }
}
