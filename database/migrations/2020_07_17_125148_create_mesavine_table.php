<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMesavineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblMesavine', function (Blueprint $table) {
//            $table->id();
            $table->primary(['ArtikalID','KomponentaID']);
            $table->foreignId('ArtikalID')
            ->constrained('tblArtikli','PLUKod')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('KomponentaID')
            ->constrained('tblArtikli','PLUKod')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

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
        Schema::dropIfExists('tblMesavine');
    }
}
