<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblDokumenta', function (Blueprint $table) {
            $table->id();

            $table->foreignId('Dokument')
            ->constrained('stpDokumenti','id')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->integer('BrDok');

            $table->integer('BrVezanogDok')->nullable();

            $table->timestamps();
//            $table->date('DatumDok');// datum
//
//            $table->date('DatumDPO');// datum

//            $table->time('Vreme');// vreme

            $table->foreignId('SifKom')->nullable()
            ->constrained('tblKomitenti','Sifra')
            ->cascadeOnUpdate();

//            $table->boolean('KomPDV');//redundantno

            $table->unsignedBigInteger('SifOj1');

            $table->foreignId('SifOj2')
            ->constrained('tblOrgJedinice','SifOj')
            ->cascadeOnUpdate();

            $table->text('Napomena')->nullable();

            $table->enum('VrstaDok',['p','s','z'])->nullable();

            $table->float('Gotovina')->default(0.0);
            $table->float('Cek')->default(0.0);
            $table->float('Kartica')->default(0.0);

            $table->unsignedBigInteger('BrFiskal')->nullable();

            $table->date('DatumF');//za predracun rok placanja
            $table->time('VremeF');

            $table->boolean('IndikatorKnjizenja')->default(false);

            $table->foreignId('Radnik')
            ->constrained('Users','PK')
            ->cascadeOnUpdate();


            $table->float('Ukupno1');

            $table->integer('BrojStola');

            $table->float('Placeno');

            $table->integer('Dan')->default(0);
        });
        Schema::create('tblDokumentaStavke', function (Blueprint $table) {
            $table->id();

            $table->foreignId('IDDOK')
                ->constrained('tblDokumenta','id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('SifraRobe')
                ->constrained('tblArtikli','PLUKod')
                ->cascadeOnUpdate();

            $table->float('Kolicina');
            $table->float('NabCena');
            $table->integer('Rabat');
//            $table->float('RazlikaUCeni');
            $table->float('ProdCena');
//            $table->timestamp('DatumVreme');
//            $table->date('Datum')->default(date('d-m-Y'));// datum
//            $table->time('Vreme')->default(date('H:i'));// vreme
            $table->boolean('Odstampano')->default(false);

        });
        /*Schema::create('tblPrometRobe', function (Blueprint $table) {
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
//            $table->string('Transakcija',3);
//            $table->integer('StopaPDV');
            $table->integer('Rabat');
            $table->integer('Prodavnica');
            $table->float('NabavnaCena');
            $table->float('ProsecnaCena');
            $table->integer('Dan');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('tblPrometRobe');
        Schema::dropIfExists('tblDokumentaStavke');
        Schema::dropIfExists('tblDokumenta');
    }
}
