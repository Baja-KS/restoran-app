@extends('orgjedinice.orgjedinice')

@section('orgjed')
    <p>Sifra:{{$organizacionajedinica->SifOj}}</p>
    <p>Naziv:{{$organizacionajedinica->Naziv}}</p>
    <p>Vrsta:{{$organizacionajedinica->Vrsta}}</p>
    <p>Adresa:{{$organizacionajedinica->Adresa ?? "N/A"}}</p>
    <p>Postanski broj:{{$organizacionajedinica->PostBr ?? "N/A"}}</p>
    <p>Mesto:{{$organizacionajedinica->Mesto ?? "N/A"}}</p>
    <p>Telefon:{{$organizacionajedinica->Telefon ?? "N/A"}}</p>
    <p>Odgovorno Lice:{{$organizacionajedinica->OdgLice ?? "N/A"}}</p>
@endsection
