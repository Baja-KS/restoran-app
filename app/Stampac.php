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

    public static function sank()
    {
        return Stampac::where('AkcijaStampaca','sank')->first();
    }
    public static function kuhinja()
    {
        return Stampac::where('AkcijaStampaca','kuhinja')->first();
    }
    public static function racun()
    {
        return Stampac::where('AkcijaStampaca','racun')->first();
    }
    public static function firma()
    {
        return Stampac::where('AkcijaStampaca','firma')->first();
    }
}
