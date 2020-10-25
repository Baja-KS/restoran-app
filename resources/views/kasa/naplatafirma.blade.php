@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <style>
        #formaContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            align-self: center;
        }
        #preview {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            align-self: center;
        }
    </style>
    <div class="container">
        <div class="col-lg-8">
            <div id="preview">
                <object data="/Restoran/public/firmapreview.pdf" type="application/pdf" width="100%" height="550px">
                    alt : <a href="/Restoran/public/firmapreview.pdf">firmapreview.pdf</a>
                </object>
            </div>
        </div>
        <form action="{{route('naplatiKasaFirma',$sto)}}" method="POST">
            @csrf
            @method('DELETE')
{{--            @if(count($dodatniRacunPoljaStavke))--}}
{{--                @foreach($dodatniRacunPolja as $polje=>$vrednost)--}}
{{--                    <input type="hidden" name="{{$polje}}" value="{{$vrednost}}">--}}
{{--                @endforeach--}}
{{--                <input type="hidden" name="brojStavki" value="{{count($dodatniRacunPoljaStavke)}}">--}}
{{--                @for($i=0;$i<count($dodatniRacunPoljaStavke);$i++)--}}
{{--                    @foreach($dodatniRacunPoljaStavke[$i] as $polje=>$vrednost)--}}
{{--                        <input type="hidden" name="{{$polje}}[]" value="{{$vrednost}}">--}}
{{--                    @endforeach--}}
{{--                @endfor--}}
{{--            @endif--}}
            @foreach($racuni as $racun)
                <input type="hidden" name="brojeviRacuna[]" value="{{$racun->brojRacuna}}">
            @endforeach
            <input type="hidden" name="uplata" value="{{$uplata}}">
            <div class="col-lg-4" id="formaContainer">
                <input type="hidden" name="firma" value="{{$komitent}}">
                <input type="hidden" name="nacinplacanja" value="{{$nacinPlacanja}}">
                <label for="brisecka">Broj Isecka:</label>
                <input type="number" min="1" step="1" id="brisecka" name="brisecka" placeholder="Broj fiskalnog isecka">
                <label for="brprimeraka">Broj Primeraka:</label>
                <input type="number" min="1" step="1" id="brprimeraka" name="brprimeraka" placeholder="Broj primeraka za stampanje">
                <button class="btn btn-success" type="submit">Naplati i odstampaj</button>
                <a class="btn btn-warning" href="{{route('editKasa',$sto)}}">Nazad</a>
            </div>
        </form>
    </div>
@endsection
