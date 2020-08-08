<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRacuniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblOtvoreniRacuni',function (Blueprint $table){
            $table->dropColumn('Popust');
        });
        Schema::table('tblOtvoreniRacuniStavke',function (Blueprint $table){
            $table->integer('Popust')->default(0);
        });
        Schema::table('tblZatvoreniRacuni',function (Blueprint $table){
            $table->dropColumn('Popust');
        });
        Schema::table('tblZatvoreniRacuniStavke',function (Blueprint $table){
            $table->integer('Popust')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblOtvoreniRacuni',function (Blueprint $table){
            $table->integer('Popust')->default(0);
        });
        Schema::table('tblOtvoreniRacuniStavke',function (Blueprint $table){
            $table->dropColumn('Popust');
        });
        Schema::table('tblZatvoreniRacuni',function (Blueprint $table){
            $table->integer('Popust')->default(0);
        });
        Schema::table('tblZatvoreniRacuniStavke',function (Blueprint $table){
            $table->dropColumn('Popust');
        });
    }
}
