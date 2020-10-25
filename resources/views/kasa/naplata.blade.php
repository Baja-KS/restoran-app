@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <style>
        #naplataContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            flex-wrap: wrap;
        }
        .naplataSporedno{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #naplataFirma {
            flex-direction: column;
        }
        #naplataFirmaCheck {
            flex-direction: row;
        }
        #naplataFirmaPolja {
            flex-direction: row;
        }
    </style>
    <div id="naplataContainer">
        <form action="{{route('naplatiKasa',$sto)}}" method="POST">
            @csrf
            @method('DELETE')
            <div id="naplataButtons" class="naplataSporedno">
                <button type="submit" class="btn mx-4 my-4 btn-success" name="placanje" id="gotovina" value="gotovina">Gotovina</button>
                <button type="submit" class="btn mx-4 my-4 btn-success" name="placanje" id="cek" value="cek">Cek</button>
                <button type="submit" class="btn mx-4 my-4 btn-success" name="placanje" id="kartica" value="kartica">Kartica</button>
            </div>
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
            <div id="naplataFields" class="naplataSporedno">
                <label for="ukupno" class="text-light">Ukupno</label>
                <input type="text" id="ukupno" name="ukupno" value="{{$cena}}">

                <label for="uplata" class="text-light">Uplata</label>
                <input type="text" id="uplata" name="uplata">

                <label for="povracaj" class="text-light">Povracaj</label>
                <input type="text" id="povracaj" name="povracaj" value="0">
            </div>
{{--            <input type="hidden" name="racun" value="{{$racun->id}}">--}}
            @foreach($brojeviRacuna as $brojRacuna)
                <input type="hidden" name="brojRacuna[]" value="{{$brojRacuna}}">
            @endforeach
            <div id="naplataFirma" class="naplataSporedno">
                <div id="naplataFirmaCheck">
                    <label for="stampanjefirma" class="text-light">Stampanje dokumenta uz racun</label>
                    <input type="checkbox" name="stampanjefirma" @if($gostID) checked disabled @endif id="stampanjefirma" value="1">
                </div>
                <div id="naplataFirmaPolja" style="display: none">
                    <label for="firma" class="text-light">Firma:</label>
                    <input type="hidden" name="idGosta" value="{{$gostID ?? 0}}">
                    <select id="firma" name="firma" @if($gostID) disabled @endif>
                        <option value="" selected disabled>Izaberi firmu</option>
                        @foreach($komitenti as $komitent)
                            <option value="{{$komitent->Sifra}}" @if($gostID===$komitent->Sifra) selected @endif>{{$komitent->Naziv}}</option>
                        @endforeach
                    </select>
{{--                    <label for="brisecka" class="text-light">Broj Isecka</label>--}}
{{--                    <input type="text" name="brisecka" id="brisecka">--}}
{{--                    <button type="submit" name="placanje" class="btn btn-success" value="previewFirma">Napravi fakturu</button>--}}
{{--                    <a id="#pregledfaktura" href="/Restoran/public/firmapreview.pdf" target="_blank" class="btn btn-success">Pregledaj fakturu</a>--}}
                </div>
                <div id="naplataNazad" class="naplataSporedno">
                    {{--                <a href="{{route('editKasa',$sto)}}" class="btn my-5 btn-warning">Nazad</a>--}}
                    <button type="submit" name="placanje" value="nazad" class="btn my-5 btn-warning">Nazad</button>
                </div>
            </div>

            {{--<div id="preview">
                <object data="/Restoran/public/racunpreview.pdf" type="application/pdf">
                    alt : <a href="/Restoran/public/racunpreview.pdf">racunpreview.pdf</a>
                </object>
            </div>--}}


        </form>
    </div>
    @if($gostID)
        <script>
            $(document).ready(function () {
                $("#stampanjefirma").val(1)
            })
        </script>
    @endif
    <script>
        $(document).ready(function () {
            let ukupno=$("#ukupno").val()
            let stampanjefirma=$("#stampanjefirma")
            let firmapolja=$("#naplataFirmaPolja")
            $("#uplata").keyup(function () {
                let trenutno=$("#uplata").val()
                $("#povracaj").val((trenutno-ukupno) > 0 ? (trenutno-ukupno) : 0)
            })
            if (stampanjefirma.is(':checked')) {
                firmapolja.show();
                // $("#gotovina").hide()
                // $("#kartica").hide()
            }
            else {
                firmapolja.hide()
                // $("#gotovina").show()
                // $("#kartica").show()
            }
            stampanjefirma.change(function () {
                firmapolja.toggle()
                // $("#gotovina").toggle()
                // $("#kartica").toggle()
            })
        })
    </script>
@endsection
