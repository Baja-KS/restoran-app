<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komitent extends Model
{
    protected $table='tblKomitenti';
    protected $primaryKey='Sifra';
    public $timestamps=false;
    protected $guarded=[];

    public function dokumenti()
    {
        return $this->hasMany(Dokument::class,'SifKom','Sifra');
    }
    public function otvoreniRacuni()
    {
        return $this->hasMany(OtvorenRacun::class,'Gost','Sifra');
    }
    public function zatvoreniRacuni()
    {
        return $this->hasMany(ZatvorenRacun::class,'Gost','Sifra');
    }
}
