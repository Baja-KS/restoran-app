<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StavkaMagacina extends Model
{
    protected $table='tblMagacinRobe';
    public $timestamps=false;
    protected $guarded=[];

    public function artikal()
    {
        return $this->belongsTo(Artikal::class,'SifraArtikla','PLUKod');
    }

    public function naStanju()
    {
        return $this->KolicinaUlaza-$this->KolicinaIzlaza;
    }
}
