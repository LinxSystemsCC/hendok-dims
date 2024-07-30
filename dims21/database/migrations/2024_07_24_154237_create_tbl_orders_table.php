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
            $table->id('intorderlinsId');
            $table->integer('intjobNumber');
            $table->integer('intproductId');
            $table->integer('intstand');
            $table->integer('intStandId');
            $table->float('fltweight');
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
