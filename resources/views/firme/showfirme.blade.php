@extends('firme.firme')

@section('firme')
    <p>ID:{{$firma->FirmaID}}</p>
    <p>Naziv:{{$firma->Naziv}}</p>
    <p>Adresa:{{$firma->Adresa}}</p>
    <p>PIB:{{$firma->PIB}}</p>
    <p>Maticni broj:{{$firma->MaticniBroj}}</p>
    <p>Tekuci racun:{{$firma->TekuciRacun}}</p>
    <p>Banka:{{$firma->Banka}}</p>
    <p>Telefon:{{$firma->Telefon}}</p>
    <p>Faks:{{$firma->Faks ?? "N/A"}}</p>
    <p>PoslovnaGodina:{{$firma->PoslovnaGodina}}</p>
    <p>Objekat:{{$firma->Objekat}}</p>
    <p>Stampac:{{$firma->stampac->Naziv}}</p>
    <p>PDV:{{$firma->PDV ? "Da" : "Ne"}}</p>

    <a href="{{route('indexFirma')}}" class="btn btn-info">Nazad</a>
@endsection
