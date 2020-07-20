@extends('layouts.welcome')

@section('content')
    <div class="content">
        <div class="title m-b-md">
            Testing
        </div>
        @auth
        <div class="links">
            <a href="https://laravel.com/docs"  class="text-danger">Unesi artikal</a>
            <a href="https://laracasts.com" class="text-danger">Prikazi sve artikle</a>
            <a href="{{route('indexKategorija')}}" class="text-success">Kategorije</a>
            <a href="https://blog.laravel.com" class="text-danger">Dodaj dokument</a>
            <a href="/" class="text-warning">Dodaj komitenta</a>
            <a href="{{route('indexJedinicamere')}}" class="text-success">Merne jedinice</a>
            <a href="https://vapor.laravel.com" class="text-danger">Vapor</a>
            <a href="https://github.com/laravel/laravel" class="text-danger">GitHub</a>
        </div>
        @else
        <p>Log in to see features ;)</p>
        @endauth
    </div>
@endsection

