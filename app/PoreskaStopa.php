<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoreskaStopa extends Model
{
    protected $table='tblPoreskeStope';
    protected $primaryKey='Sifra';
    public $timestamps=false;
    protected $guarded=[];

    //relacije
    public function artikli()
    {
        return $this->hasMany(Artikal::class,'PLUKod','Sifra');
    }
}
