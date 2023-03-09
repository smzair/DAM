<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_activity_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('log_name');
            $table->text('description')->nullable();
            $table->string('event');
            $table->string('subject_type');
            $table->bigInteger('subject_id');
            $table->string('causer_type');
            $table->bigInteger('causer_id');
            $table->json('properties')->nullable();
            // $table->longText('properties')->nullable();
            $table->string('batch_uuid')->nullable();
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
        Schema::dropIfExists('client_activity_logs');
    }
}
?>