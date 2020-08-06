<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblFirme', function (Blueprint $table) {
            $table->id('FirmaID');
            $table->string('Naziv');//mora
            $table->string('Adresa');//mora
            $table->string('PIB');//mora
            $table->string('MaticniBroj');
            $table->string('TekuciRacun');
            $table->string('Banka');
            $table->string('Telefon');
            $table->string('Faks')->nullable();
            $table->timestamps();
            $table->year('PoslovnaGodina')->default(date("Y"));
            $table->string('Objekat');
            $table->foreignId('StampacID')
            ->constrained('tblStampaci','StampacID')
            ->cascadeOnUpdate();
            $table->boolean('PDV')->default(true);
//            $table->boolean('Aktivan')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblFirme');
    }
}
