<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizacionaJedinica extends Model
{
    protected $table='tblOrgJedinice';
    protected $primaryKey='SifOj';
    public $timestamps=false;
    protected $guarded=[];

    public function dokumenti()
    {
        return $this->hasMany(Dokument::class,'SifOj2','SifOj');
    }
}
