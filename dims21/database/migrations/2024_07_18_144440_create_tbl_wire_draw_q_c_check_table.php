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
        Schema::create('tblWireDrawQCCheck', function (Blueprint $table) {
            $table->id('intQcId');
            $table->integer('intJobNumber');
            $table->integer('intProductId');
            $table->integer('intStand');
            $table->string('strTensileTicketNumber');
            $table->string('strMPATolerance');
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
        Schema::dropIfExists('tblWireDrawQCCheck');
    }
}
