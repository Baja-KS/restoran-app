<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStavkeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblDokumentaStavke', function (Blueprint $table) {
            $table->float('StaraProdajnaCena')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblDokumentaStavke', function (Blueprint $table) {
            $table->dropColumn('StaraProdajnaCena');
        });
    }
}
