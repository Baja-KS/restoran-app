<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFirmeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblFirme', function (Blueprint $table) {
            $table->dropForeign(['StampacID']);
            $table->dropColumn('StampacID');
            $table->enum('FiskalniStampac',['INTRASTER','GENEKO','WINGS']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblFirme', function (Blueprint $table) {
            $table->dropColumn('FiskalniStampac');
        });
    }
}
