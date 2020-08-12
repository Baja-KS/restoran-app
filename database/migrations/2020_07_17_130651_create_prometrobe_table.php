<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrometrobeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblPrometRobe', function (Blueprint $table) {
            $table->id('StavkaPrometa');

            $table->foreignId('BrojDokumentaID')
            ->constrained('tblDokumenta','id')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->unsignedBigInteger('BrojDokumenta');

            $table->timestamp('DatumPrometa');

            $table->unsignedBigInteger('SifraKomitenta');

            $table->foreignId('SifraArtikla')
            ->constrained('tblArtikli','PLUKod')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->float('Kolicina');
            $table->float('Cena');
            $table->string('Transakcija',3);
            $table->integer('StopaPDV');
            $table->integer('Rabat');
            $table->integer('Prodavnica');
            $table->float('NabavnaCena');
            $table->float('ProsecnaCena');
            $table->integer('Dan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblPrometRobe');
    }
}
