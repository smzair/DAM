<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->string('subject');
            $table->text('discription');
            $table->enum('is_seen',[0,1])->default(0)->comment('0 for not seen , 1 for seen');
            $table->integer('seen_by')->unsigned()->default(0);
            $table->dateTime('seen_at')->default('0000-00-00 00:00:00');
            $table->enum('is_manual_notification',['Yes','No'])->default('No');
            $table->integer('created_by')->unsigned();
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
        Schema::dropIfExists('client_notifications');
    }
}
