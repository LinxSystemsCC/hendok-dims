<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblWireDrawQCCheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_wire_draw_qc_check', function (Blueprint $table) {
            $table->id('intQcId');
            $table->integer('intJobNumber');
            $table->integer('intProductId');
            $table->integer('intStand');
            $table->integer('intTensileTicketNumber');
            $table->string('strMpa');
            $table->datetime('dtQCDateTime');
            $table->float('fltWireSize');
            $table->integer('intUserId');
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
        Schema::dropIfExists('tbl_wire_draw_qc_check');
    }
}
