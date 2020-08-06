<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtvorenracunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblOtvoreniRacuni', function (Blueprint $table) {
            $table->id('brojRacuna');
            $table->unsignedBigInteger('Sto');
            $table->foreignId('Gost')
                ->nullable()
                ->constrained('tblKomitenti','Sifra')
                ->cascadeOnUpdate();
            $table->foreignId('Radnik')
                ->constrained('Users','PK')
                ->cascadeOnUpdate();
            $table->text('Napomena')->nullable();
            $table->float('UkupnaCena');
            $table->integer('Popust')->default(0);
            $table->timestamps();

        });
        Schema::create('tblOtvoreniRacuniStavke',function (Blueprint $table){
            $table->id();
            $table->foreignId('brRacuna')
                ->constrained('tblOtvoreniRacuni','brojRacuna')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('Artikal')
                ->constrained('tblArtikli','PLUKod')
                ->cascadeOnUpdate();
            $table->float('Kolicina');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblOtvoreniRacuniStavke');
        Schema::dropIfExists('tblOtvoreniRacuni');

    }
}
