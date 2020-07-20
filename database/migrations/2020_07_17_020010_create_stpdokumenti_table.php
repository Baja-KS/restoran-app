<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStpdokumentiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stpDokumenti', function (Blueprint $table) {
            $table->id();
            $table->string('Modul');
            $table->string('Sifra')->unique();
            $table->string('UI');
            $table->text('Opis');
            $table->string('PDV');
            $table->enum('MPVP',['VP','MP']);
            $table->boolean('AutoKnj')->default(false);
            $table->boolean('AKKorisnik')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stpDokumenti');
    }
}
