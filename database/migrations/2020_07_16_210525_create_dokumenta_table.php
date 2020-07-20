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

            $table->date('DatumDok');// datum

            $table->date('DatumDPO');// datum

            $table->time('Vreme');// vreme

            $table->foreignId('SifKom')
            ->constrained('tblKomitenti','Sifra')
            ->cascadeOnUpdate();

            $table->boolean('KomPDV');//redundantno

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

            $table->date('DatumF');
            $table->time('VremeF');

            $table->tinyInteger('IndikatorKnjizenja')->default(0);

            $table->foreignId('Radnik')
            ->constrained('Users','PK')
            ->cascadeOnUpdate();


            $table->float('Ukupno1');

            $table->integer('BrojStola');

            $table->float('Placeno');

            $table->integer('Dan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblDokumenta');
    }
}
