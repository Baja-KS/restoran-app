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
            background-color: saddlebrown;
        }
    </style>
    <div id="prodajaContainer">
        <div>
            <a class="btn m-lg-4 btn-info"  @if($svi) href="{{route('dnevnaProdajaSvihKonobara')}}" @else href="{{route('dnevnaProdajaKonobara')}}" @endif>Dnevni pregled</a>
            <a class="btn m-lg-4 btn-info"  @if($svi) href="{{route('nedeljnaProdajaSvihKonobara')}}" @else href="{{route('nedeljnaProdajaKonobara')}}" @endif>Nedeljni pregled</a>
            <a class="btn m-lg-4 btn-info"  @if($svi) href="{{route('mesecnaProdajaSvihKonobara')}}" @else href="{{route('mesecnaProdajaKonobara')}}" @endif>Mesecni pregled</a>
            <a class="btn m-lg-4 btn-warning" href="{{route('home')}}">Nazad</a>
        </div>
        <p class="text-light font-weight-bold">Ili</p>
        <div class="text-light font-weight-bold">
            <form @if($svi) action="{{route('odDoProdajaSvihKonobara')}}" @else action="{{route('odDoProdajaKonobara')}}" @endif method="GET">
                @csrf
                <span>Od:</span>
                <input type="date" class="text-black-50" name="od" required>
                <span>Do:</span>
                <input type="date" class="text-black-50" name="do" required>
                <button type="submit" class="btn btn-info">Pregled</button>
            </form>
        </div>
        <div>
            @yield('tabela')
        </div>
    </div>
@endsection
