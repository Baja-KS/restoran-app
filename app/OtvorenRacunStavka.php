<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtvorenRacunStavka extends Model
{
    protected $table='tblOtvoreniRacuniStavke';
    protected $guarded=[];
    public $timestamps=false;

    public function racun()
    {
        return $this->belongsTo(OtvorenRacun::class,'brRacuna','brojRacuna');
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
