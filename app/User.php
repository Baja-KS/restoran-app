<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey='PK';
    protected $table='Users';
    protected $guarded=[];
//    protected $fillable=['PK','UserID','CompleteName','password','Admin','Objekat','Firma','Kasa'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function artikli()
    {
        return $this->hasMany(Artikal::class,'PLUKod','PK');
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//    ];
    public function isAdmin()
    {
        return $this->Admin == "Y";
    }

    public function otvoreniRacuni()
    {
        return $this->hasMany(OtvorenRacun::class,'Radnik','PK');
    }
    public function zatvoreniRacuni()
    {
        return $this->hasMany(ZatvorenRacun::class,'Radnik','PK');
    }
}
