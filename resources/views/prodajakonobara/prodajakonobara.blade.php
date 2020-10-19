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
            <a class="btn m-lg-4 btn-info"  href="{{route('pregledProdajaKonobara',['svi'=>$svi,'tipPregleda'=>"dan"])}}">Dnevni pregled</a>
            <a class="btn m-lg-4 btn-info"  href="{{route('pregledProdajaKonobara',['svi'=>$svi,'tipPregleda'=>"nedelja"])}}">Nedeljni pregled</a>
            <a class="btn m-lg-4 btn-info"  href="{{route('pregledProdajaKonobara',['svi'=>$svi,'tipPregleda'=>"mesec"])}}">Mesecni pregled</a>
            <a class="btn m-lg-4 btn-warning" href="{{route('home')}}">Nazad</a>
        </div>
        <p class="text-light font-weight-bold">Ili</p>
        <div class="text-light font-weight-bold">
            <form action="{{route('pregledProdajaKonobara',['svi'=>$svi,'tipPregleda'=>"datum"])}}" method="GET">
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
