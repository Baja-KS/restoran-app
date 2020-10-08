<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministracijaController extends Controller
{
    public function index()
    {
        return view('administracija.base');
    }
}
