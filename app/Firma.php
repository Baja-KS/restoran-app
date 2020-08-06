<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firma extends Model
{
    protected $table='tblFirme';
    protected $primaryKey='FirmaID';
    protected $guarded=[];

    public function stampac()
    {
        return $this->belongsTo(Stampac::class,'StampacID','StampacID');
    }

//    public function aktiviraj()
//    {
//        $this->update(['Aktivan'=>true]);
//    }
//
//    public function deaktiviraj()
//    {
//        $this->update(['Aktivan'=>false]);
//    }

}
