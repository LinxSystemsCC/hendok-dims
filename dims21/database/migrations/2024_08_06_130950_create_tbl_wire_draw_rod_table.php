<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblWireDrawRodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblWireDrawRods', function (Blueprint $table) {
            $table->id('intRodId');
            $table->dateTime('dtmDate');
            $table->integer('intJobNumber');
            $table->integer('intRodSupplier');
            $table->string('strRodCode');
            $table->string('strCastNumber');
            $table->string('strSerialNumber');
            $table->string('strBatchNumber');
            $table->float('fltRodElongation');
            $table->float('fltRodMpa');
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
        Schema::dropIfExists('tblWireDrawRods');
    }
}
