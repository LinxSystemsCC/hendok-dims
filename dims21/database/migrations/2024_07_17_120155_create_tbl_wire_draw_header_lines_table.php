<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblWireDrawHeaderLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblWireDrawHeaders', function (Blueprint $table) {
            $table->id('intHeaderId');
            $table->string('strReference');
            $table->string('strType');
            $table->integer('intCustomerId');
            $table->datetime('dtDateStart')->nullable();
            $table->datetime('dtDateEnd')->nullable();
            $table->integer('intWireDrawMachineId');
            $table->integer('intProductId');
            $table->float('fltMassRequired');
            $table->float('fltMassProduced ')->default('0');
            $table->string('strJobStatus')->default('Pending');
            $table->integer('intNoOfStand')->default('0');
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
        Schema::dropIfExists('tblWireDrawHeaders');
    }
}
