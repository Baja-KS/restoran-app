<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumentaStavkeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblDokumentaStavke', function (Blueprint $table) {
            $table->id();

            $table->foreignId('IDDOK')
            ->constrained('tblDokumenta','id')
            ->cascadeOnUpdate();

            $table->foreignId('SifraRobe')
            ->constrained('tblArtikli','PLUKod')
            ->cascadeOnUpdate();

            $table->float('Kolicina');
            $table->float('NabCena');
            $table->integer('Rabat');
            $table->float('RazlikaUCeni');
            $table->float('ProdCena');
            $table->timestamp('DatumVreme');
//            $table->date('Datum')->default(date('d-m-Y'));// datum
//            $table->time('Vreme')->default(date('H:i'));// vreme
            $table->boolean('Odstampano')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblDokumentaStavke');
    }
}
