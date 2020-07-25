<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stampac extends Model
{
    protected $table='tblStampaci';
    protected $primaryKey='StampacID';
    protected $guarded=[];
    public $timestamps=false;

    public function firme()
    {
        return $this->hasMany(Firma::class,'StampacID','StampacID');
    }
}
