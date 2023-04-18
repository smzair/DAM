<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToEditingAllocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('editing_allocations', function (Blueprint $table) {
            $table->integer('uploaded_qty')->default(0)->length(10)->unsigned()->after('user_role');
            $table->string('file_path')->nullable()->after('uploaded_qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('editing_allocations', function (Blueprint $table) {
            $table->dropColumn('uploaded_qty');
            $table->dropColumn('file_path');
        });
    }
}
