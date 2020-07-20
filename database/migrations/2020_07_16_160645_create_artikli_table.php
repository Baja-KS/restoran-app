<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblArtikli', function (Blueprint $table) {
            $table->id('RobaID');

            $table->unsignedBigInteger('PLUKod')->unique();//najveci trenutni+1

            $table->string('Naziv');

            $table->foreignId('Kategorija')  //foreign po KategorijaID iz tblKategorije
            ->constrained('tblKategorije','KategorijaID')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('Jedinicamere')
            ->constrained('tblIJM','JMID')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();//foreign po JMID iz tblIJM


            $table->unsignedBigInteger('BarKod')->unique();//ovde konkretno jednak PLUKod-u

            $table->foreignId('Radnik')
            ->constrained('Users','PK')
            ->cascadeOnUpdate();//foreign po PK iz Users


            $table->foreignId('PoreskaStopa');//foreign po TarifaID iz tblPoreskeStope


            $table->float('PDV');//racuna se -> poreska stopa*cena --OVO NE BIH RADIO--

            //$table->date('Datum')->default(date('d-m-Y'));// datum

            //$table->time('Vreme')->default(date('H:i'));// vreme

            $table->timestamp('DatumVreme');

            $table->boolean('Normativ')->default(false);
            $table->boolean('Aktivan')->default(false);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblArtikli');
    }
}
