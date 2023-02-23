<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('Address')->nullable();
            $table->string('Company')->nullable();
            $table->json('brand')->nullable();
            $table->string('Gst_number')->nullable();
            $table->string('verifyToken')->nullable();
            $table->boolean('verification_status') ;
            $table->boolean('status')->default(1);
            $table->string('photo')->default('avatar.jpg');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
