<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firma extends Model
{
    protected $table='tblFirme';
    protected $primaryKey='FirmaID';
    public $timestamps=false;
    protected $guarded=[];

    public function stampac()
    {
        return $this->belongsTo(Stampac::class,'StampacID','StampacID');
    }

}
