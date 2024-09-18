<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblWireDrawHeaderLines', function (Blueprint $table) {
            $table->id('intOrderLineId');
            $table->integer('intJobNumber');
            $table->integer('intProductId');
            $table->integer('intStand');
            $table->integer('intStandId');
            $table->float('fltWeight');
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
        Schema::dropIfExists('tblWireDrawHeaderLines');
    }
}
