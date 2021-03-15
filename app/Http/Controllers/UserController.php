<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function edit(User $user)
    {
        return view('auth.editUser',['korisnik'=>$user]);
    }

    public function update(User $user)
    {
        $admin=\request('admin') ? "Y" : "N";
        $attributes=\request()->validate([
            'uid' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'ob'=>['required','integer','min:1'],
            'fir'=>['required','integer','min:1'],
            'ka'=>['required','integer','min:1'],]);
        $user->update([
            'CompleteName'=>$attributes['name'],
            'UserID'=>$attributes['uid'],
            'Objekat'=>$attributes['ob'],
            'Firma'=>$attributes['fir'],
            'Kasa'=>$attributes['ka'],
            'Admin'=>$admin
        ]);
        return Redirect::route('register');
    }
}
