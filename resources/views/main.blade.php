@extends('layouts.welcome')

@section('content')
    <div class="content">
        <div class="title m-b-md">
            Testing
        </div>
        @auth
        <div class="links">
            <a href="https://laravel.com/docs"  class="text-danger">Artikli</a>
            <a href="{{route('indexPoreskastopa')}}" class="text-success">Poreske stope</a>
            <a href="{{route('indexKategorija')}}" class="text-success">Kategorije</a>
            <a href="https://blog.laravel.com" class="text-danger">Dokumenti</a>
            <a href="{{route('indexKomitent')}}" class="text-success">Komitenti</a>
            <a href="{{route('indexJedinicamere')}}" class="text-success">Merne jedinice</a>
            <a href="https://vapor.laravel.com" class="text-danger">Kasa</a>
            <a href="https://github.com/laravel/laravel" class="text-danger">GitHub</a>
        </div>
        @else
        <p>Log in to see features ;)</p>
        @endauth
    </div>
@endsection

