<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminControlFileUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_control_file_uploads', function (Blueprint $table) {
            $table->id();
            $table->integer('lot_id')->unsigned();
            $table->integer('wrc_id')->unsigned();
            $table->enum('service', ['Shoot', 'Creative', 'Cataloging','Editing'])->comment('1 for Shoot, 2 for Creative, 3 for Cataloging, 4 for Editing')->nullable();
            $table->string('file_path')->nullable();
            $table->string('filename')->nullable();
            $table->integer('uploaded_by')->unsigned();
            $table->integer('updated_by')->unsigned();
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
        Schema::dropIfExists('admin_control_file_uploads');
    }
}
