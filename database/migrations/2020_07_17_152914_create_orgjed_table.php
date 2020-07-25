<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgjedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblOrgJedinice', function (Blueprint $table) {
            $table->id('SifOj');
            $table->string('Vrsta',1);
            $table->string('Naziv');
            $table->string('Adresa')->nullable();
            $table->string('PostBr')->nullable();
            $table->string('Mesto')->nullable();
            $table->string('Telefon')->nullable();
            $table->string('OdgLice')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblOrgJedinice');
    }
}
