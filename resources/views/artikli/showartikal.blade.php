@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <div class="container-fluid">
        <div class="col-md-4">
            <h4 class="text">Naziv:{{$artikal->Naziv}}</h4>
            <h4>Kategorija:{{$artikal->podkategorija->Naziv}}</h4>
            <h4>Jedinica Mere:{{ $artikal->jedinicamere->Naziv}}</h4>
            <h4>Poreska Stopa:{{$artikal->poreskastopa->Opis." - ".$artikal->poreskastopa->Vrednost}}%</h4>
            <h4>PLUKod:{{$artikal->PLUKod}}</h4>
            <h4>Barkod:{{$artikal->BarKod}}</h4>
        </div>
        <div class="col-md-4">
            <h4 class="text">Prodavnica:{{$artikal->magacin->Prodavnica}}</h4>
            @if(!$artikal->Normativ)
            <h4>Kolicina Ulaza:{{$artikal->magacin->KolicinaUlaza}}</h4>
            <h4>Kolicina Izlaza:{{$artikal->magacin->KolicinaIzlaza}}</h4>
            @endif
            <h4>Zadnja Prodajna cena:{{$artikal->magacin->ZadnjaProdajnaCena}}</h4>
            <h4>Zadnja Nabavna cena:{{$artikal->magacin->ZadnjaNabavnaCena}}</h4>
        </div>
        <div class="col-md-4">
            <h4>Normativ:{{$artikal->Normativ ? "Da" : "Ne"}}</h4>
            <h4>Aktivan:{{$artikal->Aktivan ? "Da" : "Ne"}}</h4>
            @if($artikal->Normativ)
                <h3>Komponente</h3>
                <hr>
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Naziv komponente</th>
                            <th>Kolicina</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($artikal->komponente as $komponenta)
                        <tr>
                            <td>{{$komponenta->Naziv}}</td>
                            <td>{{\App\Artikal::kolicinaUMesavini($artikal,$komponenta)." ".$komponenta->jedinicamere->Naziv}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
