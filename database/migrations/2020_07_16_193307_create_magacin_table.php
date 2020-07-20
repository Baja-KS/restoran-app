<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMagacinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblMagacinRobe', function (Blueprint $table) {
            $table->id();

            $table->foreignId('SifraArtikla')
            ->constrained('tblArtikli','PLUKod')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->float('KolicinaUlaza')->default(0);
            $table->float('KolicinaIzlaza')->default(0);
            $table->float('ZadnjaProdajnaCena');
            $table->float('ZadnjaNabavnaCena');

            //Prodavnica
            $table->integer('Prodavnica');// redundantno

            //Prosecna Cena
            $table->float('ProsecnaCena');// redundantno
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblMagacinRobe');
    }
}
