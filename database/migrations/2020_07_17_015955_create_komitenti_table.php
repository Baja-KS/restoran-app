<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomitentiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblKomitenti', function (Blueprint $table) {
            $table->id('Sifra');
            $table->string('Naziv');//mora
            $table->integer('VrKomitenta')->default(0);
            $table->string('Adresa');//mora
            $table->string('PostBr')->nullable();
            $table->string('Mesto')->nullable();
            $table->string('Drzava')->default('Srbija');
            $table->string('Telefon')->nullable();
            $table->string('OdgLice')->nullable();
            $table->string('ZR')->nullable();
            $table->string('MatBr')->nullable();
            $table->string('RegBr')->nullable();
            $table->string('PIB');//mora
            $table->text('Napomena')->nullable();
            $table->string('Web')->nullable();
            $table->string('E-mail')->nullable();
            $table->boolean('PDV')->default(true);
            $table->boolean('Inostrani')->default(false);
            $table->float('PrenetoStanje')->default(0.0);
            $table->boolean('Dobavljac')->default(false);
            $table->boolean('Kupac')->default(false);
            $table->integer('Popust')->default(0);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblKomitenti');
    }
}
