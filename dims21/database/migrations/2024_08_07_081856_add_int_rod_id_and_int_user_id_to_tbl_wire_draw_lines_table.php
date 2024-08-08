<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIntRodIdAndIntUserIdToTblWireDrawLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblWireDrawLines', function (Blueprint $table) {
            $table->integer('intRodId')->default(0);
            $table->integer('intUserId')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblWireDrawLines', function (Blueprint $table) {
            $table->dropColumn(['intRodId', 'intUserId']);
        });
    }
}

