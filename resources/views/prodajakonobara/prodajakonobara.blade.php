@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <style>
        #prodajaContainer {
            display: flex;
            justify-content: center;
            align-self: center;
            align-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
    <div id="prodajaContainer">
        <div>
            <a class="btn m-lg-4 btn-info"  @if($svi) href="{{route('dnevnaProdajaSvihKonobara')}}" @else href="{{route('dnevnaProdajaKonobara')}}" @endif>Dnevni pregled</a>
            <a class="btn m-lg-4 btn-info"  @if($svi) href="{{route('nedeljnaProdajaSvihKonobara')}}" @else href="{{route('nedeljnaProdajaKonobara')}}" @endif>Nedeljni pregled</a>
            <a class="btn m-lg-4 btn-info"  @if($svi) href="{{route('mesecnaProdajaSvihKonobara')}}" @else href="{{route('mesecnaProdajaKonobara')}}" @endif>Mesecni pregled</a>
            <a class="btn m-lg-4 btn-warning" href="{{route('home')}}">Nazad</a>
        </div>
        <div>
            @yield('tabela')
        </div>
    </div>
@endsection
