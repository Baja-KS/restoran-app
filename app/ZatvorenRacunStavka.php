<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZatvorenRacunStavka extends Model
{
    protected $table='tblZatvoreniRacuniStavke';
    protected $guarded=[];
    public $timestamps=false;

    public function racun()
    {
        return $this->belongsTo(ZatvorenRacun::class,'brRacuna','brojRacuna');
    }

    public function artikal()
    {
        return $this->belongsTo(Artikal::class,'Artikal','PLUKod');
    }
    public function cenaSaPopustom()
    {
        $popust=$this->Popust;
        $cena=$this->artikal->magacin->ZadnjaProdajnaCena;
        return $cena-($popust/100*$cena);
    }
}
