<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZatvoreniracuniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblZatvoreniRacuni', function (Blueprint $table) {
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
            $table->enum('NacinPlacanja',['Gotovina','Cek','Kartica']);
            $table->timestamps();

        });
        Schema::create('tblZatvoreniRacuniStavke',function (Blueprint $table){
            $table->id();
            $table->foreignId('brRacuna')
                ->constrained('tblZatvoreniRacuni','brojRacuna')
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
        Schema::dropIfExists('tblZatvoreniRacuniStavke');
        Schema::dropIfExists('tblZatvoreniRacuni');
    }
}
