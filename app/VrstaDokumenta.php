<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VrstaDokumenta extends Model
{
    protected $table='stpDokumenti';
    protected $guarded=[];
    public $timestamps=false;

    public function dokumenti()
    {
        return $this->hasMany('tblDokumenta','Dokument','id');
    }
}
