<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZatvorenRacun extends Model
{
    protected $table='tblZatvoreniRacuni';
    protected $primaryKey='brojRacuna';
    protected $guarded=[];

    public function stavke()
    {
        return $this->hasMany(ZatvorenRacunStavka::class,'brRacuna','brojRacuna');
    }

    public function gost()
    {
        return $this->belongsTo(Komitent::class,'Gost','Sifra');
    }
    public function radnik()
    {
        return $this->belongsTo(User::class,'Radnik','PK');
    }
    public function UkupnaCena()
    {
        $ukupno=0;
        foreach ($this->stavke as $stavka)
        {
            $ukupno+=$stavka->cenaSaPopustom();
        }
        return $ukupno;
    }
}
