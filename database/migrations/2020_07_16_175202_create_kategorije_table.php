<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategorijeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblKategorije',function (Blueprint $table){
            $table->id('SifKat');
            $table->string('Naziv');
        });
        Schema::create('tblPodKategorije',function (Blueprint $table){
            $table->id('SifKat');
            $table->string('Naziv');
            $table->text('Opis')->nullable();
            $table->foreignId('GlavnaKategorija')
                ->constrained('tblKategorije','SifKat')
                ->cascadeOnUpdate();//vezano za tblPodKategorije
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblKategorije');
        Schema::dropIfExists('tblPodKategorije');
    }
}
