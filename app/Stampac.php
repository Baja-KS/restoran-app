<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class Stampac extends Model
{
    protected $table='tblStampaci';
    protected $primaryKey='StampacID';
    protected $guarded=[];
    public $timestamps=false;



//    public function firme()
//    {
//        return $this->hasMany(Firma::class,'StampacID','StampacID');
//    }

    public static function dostupniStampaci()
    {
        $sh=shell_exec('lpstat -p -d');
        $sharray=explode("\n",$sh);
        array_pop($sharray);
        array_pop($sharray);
        $printers=[];
        foreach ($sharray as $shitem)
        {
            $shitem=explode(" ",$shitem);
            if (count($shitem)<6)
                continue;
            $printer=$shitem[1];
            $status=$shitem[5];
            if ($status!=='disabled' and $shitem[3]==='idle.')
            {
                $printers[]=$printer;
            }
        }
        return $printers;
    }

    public static function dostupneAkcije()
    {
        $akcije=['sank','kuhinja','racun','firma'];
        $dostupne=[];
        foreach ($akcije as $akcija)
        {
            if (Stampac::where('AkcijaStampaca',$akcija)->count()==0)
            {
                $dostupne[]=$akcija;
            }
        }
        return $dostupne;
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
