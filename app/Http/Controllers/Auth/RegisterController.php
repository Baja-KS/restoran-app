<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {

        return Validator::make($data, [
            'uid' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'ob'=>['required','integer','min:1'],
            'fir'=>['required','integer','min:1'],
            'ka'=>['required','integer','min:1'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],[],['UserID','CompleteName','Objekat','Firma','Kasa','Password']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    /*
      $table->string('UserID');
            $table->string('CompleteName');
            $table->string('password');
            $table->enum('Admin',['Y','N'])->default('N');
            $table->unsignedInteger('Objekat');
            $table->unsignedInteger('Firma');
            $table->unsignedInteger('Kasa');*/
    protected function create(array $data)
    {
        return User::create([
            'UserID' => $data['uid'],
            'CompleteName' => $data['name'],
            'Objekat' => $data['ob'],
            'Firma' => $data['fir'],
            'Kasa' => $data['ka'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
