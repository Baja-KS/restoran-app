<?php

namespace App\Providers;

use App\OtvorenRacun;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin',function (){
            return auth()->user()->isAdmin();
        });
        //
        Gate::define('accessKasa',function (User $user,$sto){
            if(OtvorenRacun::where('Sto',$sto)->count()===0)
                return true;
            return OtvorenRacun::where('Sto',$sto)->first()->Radnik===$user->PK;
        });

    }
}
