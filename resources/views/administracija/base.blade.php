@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <style>
        /*#tabs {*/
        /*    display: flex;*/
        /*    flex-direction: row;*/
        /*    top: 10vh;*/
        /*}*/
        #back {
            display: flex;
            justify-content: center;
        }
        #tab-content {
            background-color: saddlebrown;
        }
    </style>
    <div>
        <div id="tabs" class="flex-lg-row my-4">
            <a href="{{route('indexKomitent')}}" class="btn mx-2 btn-info">Dobavljaci</a>
            <a href="{{route('listaRacuna')}}" class="btn mx-2 btn-info">Lista racuna</a>
            <a href="{{route('listaGotovinskihRacuna')}}" class="btn mx-2 btn-info">Lista gotovinskih racuna</a>
            <a href="{{route('listaNivelacije')}}" class="btn mx-2 btn-info">Lista nivelacija</a>
            <a href="{{route('indexPrijemnica')}}" class="btn mx-2 btn-info">Lista prijemnica</a>
            <a href="" class="btn mx-2 btn-info">Lager lista</a>
            <a href="" class="btn mx-2 btn-info">Lager komponenti</a>
        </div>
        <div id="tab-content" class="container border-danger border">
            @yield('tab-content')
        </div>
        <div id="back">
            <a href="{{route('home')}}" class="btn btn-warning">Nazad na pocetnu</a>
        </div>
    </div>
@endsection
