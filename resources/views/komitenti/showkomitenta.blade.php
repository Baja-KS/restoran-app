@extends('administracija.base')

@section('tab-content')
<div class="container-fluid">
    <div class="col-md-2">
        <p>Naziv Komitenta:{{$komitent->Naziv}}</p>
        <p>Adresa:{{$komitent->Adresa}}</p>
        <p>PIB:{{$komitent->PIB}}</p>
        <p>Postanski broj:{{$komitent->PostBr ?? "N/A"}}</p>
    </div>
    <div class="col-md-2">
        <p>Mesto:{{$komitent->Mesto ?? "N/A"}}</p>
        <p>Telefon:{{$komitent->Telefon ?? "N/A"}}</p>
        <p>Odgovorno Lice:{{$komitent->OdgLice ?? "N/A"}}</p>
        <p>Ziroracun:{{$komitent->ZR ?? "N/A"}}</p>
    </div>
    <div class="col-md-2">
        <p>Maticni Broj:{{$komitent->MatBr ?? "N/A"}}</p>
        <p>Vrednost Komitenta:{{$komitent->VrKomitenta ?? "N/A"}}</p>
        <p>Registarski broj:{{$komitent->RegBr ?? "N/A"}}</p>
        <p>Napomena:{{$komitent->Napomena ?? "N/A"}}</p>
    </div>
    <div class="col-md-2">
        <p>Web:{{$komitent->Web ?? "N/A"}}</p>
        <p>E-mail:{{$komitent['E-mail'] ?? "N/A"}}</p>
        <p>Preneto stanje:{{$komitent->PrenetoStanje ?? "N/A"}}</p>
        <p>Popust:{{$komitent->Popust ?? "N/A"}}</p>
    </div>
    <div class="col-md-2">
        <p>PDV:{{$komitent->PDV ? "Da" : "Ne"}}</p>
        <p>Dobavljac:{{$komitent->Dobavljac ? "Da" : "Ne"}}</p>
        <p>Kupac:{{$komitent->Kupac ? "Da" : "Ne"}}</p>
        <p>Inostran:{{$komitent->Inostran ? "Da" : "Ne"}}</p>
        <p>Drzava:{{$komitent->Drzava}}</p>
    </div>
</div>
@endsection
