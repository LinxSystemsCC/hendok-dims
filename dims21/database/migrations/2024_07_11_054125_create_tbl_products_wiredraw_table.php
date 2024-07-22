<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProductsWireDrawTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblProductsWireDraw', function (Blueprint $table) {
            $table->id('intProductId');
            $table->string('strProductName');
            $table->float('ftlWireSize');
            $table->string('strSizeTolerance');
            $table->string('strMPATolerance');
            $table->integer('intCustomerId');
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
        Schema::dropIfExists('tblProductsWireDraw');
    }
}
