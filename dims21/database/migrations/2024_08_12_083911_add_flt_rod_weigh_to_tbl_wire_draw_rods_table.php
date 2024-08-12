<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFltRodWeighToTblWireDrawRodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblWireDrawRods', function (Blueprint $table) {
            $table->float('fltRodWeigh')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblWireDrawRods', function (Blueprint $table) {
            $table->dropColumn('fltRodWeigh');
        });
    }
}
