<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jedinicamere extends Model
{
    protected $table='tblIJM';
    protected $primaryKey='JMID';
    public $timestamps=false;
    protected $guarded=[];
    public function artikli()
    {
        return $this->hasMany(Artikal::class,'Jedinicamere','JMID');
    }
}
