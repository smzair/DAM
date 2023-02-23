<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToEditingWrcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('editing_wrcs', function (Blueprint $table) {
            $table->boolean('wrc_status')->default(1)->comment('1 for acrive, 2 for Wrc Rejected')->after('documentUrl');
            $table->string('invoice_number')->nullable()->after('wrc_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('editing_wrcs', function (Blueprint $table) {
            $table->dropColumn('wrc_status');
            $table->dropColumn('invoice_number');
        });
    }
}
