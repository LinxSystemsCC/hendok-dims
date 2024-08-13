<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropStrTypeFromTblWireDrawHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblWireDrawHeaders', function (Blueprint $table) {
            $table->dropColumn('strType');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblWireDrawHeaders', function (Blueprint $table) {
            $table->string('strType')->nullable();
        });
    }
}
