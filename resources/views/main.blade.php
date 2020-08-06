@extends('layouts.welcome')

@section('content')
    <style>
        #linkovi {
            position: absolute;
            top: 5%;
            right: 25%;

            max-height: 100%;
        }
        #linkovi a {
            max-height: 100%;
        }
        @media screen and (max-height: 500px){
            #linkovi .btn {
                padding-top: 0px !important;
                padding-bottom: 0px !important;
                max-height: 10%;
            }
        }
        #stolovi1 {
            position: absolute;
            top: 5%;
            left: 0vw;
            width: 100%;
        }
        #sto1{
            position: absolute;
            left: 5vw;
        }
        #sto2 {
            position: absolute;
            left: 0vw;
        }
        #sto3 {
            position: absolute;
            left: 15%;
        }
        #sto4 {
            position: absolute;
            left: 30%;
        }
        #sto5 {
            position: absolute;
            left: 60%;
        }
        #stolovi4 {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: absolute;
            bottom: 0%;
            right: 0%;
        }
        #stolovi4 .sto {
            margin-top: 10% !important;
            margin-bottom: 30% !important;
        }
        /*@media only screen and (min-width: 900px) and (max-width: 1100px) {
            #sto13 {
                margin-top: 0% !important;
                margin-bottom: 10% !important;
            }
            #sto12 {
                margin-top: 10% !important;
                margin-bottom: 0%;
            }
            #sto11 {
                margin-top: 33% !important;
                margin-bottom: -10%;
            }
            #sto10 {

                margin-bottom: 50% !important;
            }

        }*/
        @media only screen and(min-width: 768px) and(max-width: 1000px) {
            #stolovi2 {
                position: absolute;
                bottom: 15%;
                left: 20%;
                width: 150%;
            }
            #sto6 {
                position: absolute;
                left: -50%;
            }
            #sto7 {
                position: absolute;
                left: 60%;
            }
        }

        #stolovi2 {
            position: absolute;
            bottom: 15%;
            left: 20%;
            width: 80%;
        }
        #sto6 {
            position: absolute;
            left: -20%;
        }
        #sto7 {
            position: absolute;
            left: -20%;
        }

        #stolovi3 {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: absolute;
            top: 5%;
            right: 5vw;
            width: 100%
        }
        #sto8 {

        }
        #sto9 {

        }

        #logout {
            position: absolute;
            bottom: 5%;
            left: 75%;
        }

        @media only screen and (min-width: 480px) and (max-width: 768px){
            #stolovi1 {
                position: absolute;
                top: 5%;
                left: 0vw;
                width: 120%;
            }
            #stolovi .btn {
                padding-top: 0px !important;
                padding-bottom: 0px !important;
                max-height: 10%;
            }
            #sto1{
                position: absolute;
                left: 50%;
            }
            #sto2 {
                position: absolute;
                left: 50%;
            }
            #sto3 {
                position: absolute;
                left: 60%;
            }
            #sto4 {
                position: absolute;
                left: 60%;
            }
            #sto5 {
                position: absolute;
                left: 70%;
            }
            #sto6 {
                position: absolute;
                left: -55%;
            }
            #sto7 {
                position: absolute;
                left: 60%;
            }

        }
        @media only screen and (min-width: 580px) and (max-width: 768px) {
            .tekst {
                font-size: 8px !important;
            }
            #stolovi3 {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                position: absolute;
                top: 5%;
                right: 0vw;
                width: 10%;
                height: 10%;
            }
            #sto9 {
                position: absolute;
                top: 10%;
            }
        }
        @media only screen and (min-width: 480px) and (max-width: 580px){
            .tekst {
                font-size: 6px !important;
            }
            #stolovi1 {
                position: absolute;
                top: 5%;
                left: 0vw;
                width: 100%;
            }
            #sto1{
                position: absolute;
                left: 5vw;
            }
            #sto2 {
                position: absolute;
                left: 7vw;
            }
            #sto3 {
                position: absolute;
                left: 100%;
            }
            #sto4 {
                position: absolute;
                left: 125%;
            }
            #sto5 {
                position: absolute;
                left: 155%;
            }
            #sto6 {
                position: absolute;
                left: -55%;
            }
            #sto7 {
                position: absolute;
                left: 60%;
            }
            #sto9 {
                position: absolute;
                top: 0%;
            }
        }
        @media only screen and (max-width: 480px) {
            .tekst {
                font-size: 4px !important;
            }
            #stolovi1 {
                position: absolute;
                top: 5%;
                left: 0vw;
                width: 100%;
            }
            #sto1{
                position: absolute;
                left: 5vw;
            }
            #sto2 {
                position: absolute;
                left: 7vw;
            }
            #sto3 {
                position: absolute;
                left: 100%;
            }
            #sto4 {
                position: absolute;
                left: 125%;
            }
            #sto5 {
                position: absolute;
                left: 155%;
            }
            #sto6 {
                position: absolute;
                left: -55%;
            }
            #sto7 {
                position: absolute;
                left: 60%;
            }
            #stolovi3 {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                position: absolute;
                top: 5%;
                right: 0vw;
                width: 10%;
                height: 10%;
            }
            #stolovi4 {
                display: flex;
                flex-direction: column;
                justify-content: space-evenly;
                position: relative;
                bottom: auto;
            }
        }



    </style>
    <div class="content">
        <div id="stolovi1" class="row">
            <div class="col-lg-2  col-md-2 col-sm-1 col-xs-1">
                <a id="sto1" @if(\App\OtvorenRacun::brojRacunaZaSto(9)>0) href="{{route('editKasa',9)}}" @else href="{{route('createKasa',9)}}" @endif class="sto btn px-lg-4 py-lg-4 mx-lg-2 px-md-2 py-md-2 mx-md-1  @if(\App\OtvorenRacun::brojRacunaZaSto(9)>0) btn-danger @else btn-light @endif"> @if(\App\OtvorenRacun::brojRacunaZaSto(9)>0) {{\App\OtvorenRacun::ukupnoZaSto(9)}} @else Sto 9 @endif</a>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                <a id="sto2" @if(\App\OtvorenRacun::brojRacunaZaSto(10)>0) href="{{route('editKasa',10)}}" @else href="{{route('createKasa',10)}}" @endif class="sto btn px-lg-4 py-lg-4 mx-lg-2 btn-light px-md-2 py-md-2 mx-md-1 @if(\App\OtvorenRacun::brojRacunaZaSto(10)>0) btn-danger @else btn-light @endif"> @if(\App\OtvorenRacun::brojRacunaZaSto(10)>0) {{\App\OtvorenRacun::ukupnoZaSto(10)}} @else Sto 10 @endif</a>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                <a id="sto3" @if(\App\OtvorenRacun::brojRacunaZaSto(11)>0) href="{{route('editKasa',11)}}" @else href="{{route('createKasa',11)}}" @endif class="sto btn px-lg-4 py-lg-4 mx-lg-2 btn-light px-md-2 py-md-2 mx-md-1 @if(\App\OtvorenRacun::brojRacunaZaSto(11)>0) btn-danger @else btn-light @endif"> @if(\App\OtvorenRacun::brojRacunaZaSto(11)>0) {{\App\OtvorenRacun::ukupnoZaSto(11)}} @else Sto 11 @endif</a>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                <a id="sto4" @if(\App\OtvorenRacun::brojRacunaZaSto(12)>0) href="{{route('editKasa',12)}}" @else href="{{route('createKasa',12)}}" @endif class="sto btn px-lg-4 py-lg-4 mx-lg-2 btn-light px-md-2 py-md-2 mx-md-1 @if(\App\OtvorenRacun::brojRacunaZaSto(12)>0) btn-danger @else btn-light @endif"> @if(\App\OtvorenRacun::brojRacunaZaSto(12)>0) {{\App\OtvorenRacun::ukupnoZaSto(12)}} @else Sto 12 @endif</a>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                <a id="sto5" @if(\App\OtvorenRacun::brojRacunaZaSto(13)>0) href="{{route('editKasa',13)}}" @else href="{{route('createKasa',13)}}" @endif class="sto btn px-lg-4 py-lg-4 mx-lg-2 btn-light px-md-2 py-md-2 mx-md-1 @if(\App\OtvorenRacun::brojRacunaZaSto(13)>0) btn-danger @else btn-light @endif"> @if(\App\OtvorenRacun::brojRacunaZaSto(13)>0) {{\App\OtvorenRacun::ukupnoZaSto(13)}} @else Sto 13 @endif</a>
            </div>
        </div>
        <div id="stolovi2" class="row">
            <div class="col-lg-2  col-md-2 col-sm-1 col-xs-1">
                <a id="sto6" @if(\App\OtvorenRacun::brojRacunaZaSto(1)>0) href="{{route('editKasa',1)}}" @else href="{{route('createKasa',1)}}" @endif class="sto btn px-lg-4 pt-lg-4 pd-lg-4 mx-lg-2 px-md-2 py-md-2 py-sm-1   @if(\App\OtvorenRacun::brojRacunaZaSto(1)>0) btn-danger @else btn-light @endif"> @if(\App\OtvorenRacun::brojRacunaZaSto(1)>0) {{\App\OtvorenRacun::ukupnoZaSto(1)}} @else Sto 1 @endif</a>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-1 col-xs-1">
                <a id="sto7" @if(\App\OtvorenRacun::brojRacunaZaSto(2)>0) href="{{route('editKasa',2)}}" @else href="{{route('createKasa',2)}}" @endif class="sto btn px-lg-4 pt-lg-4 float-md-right pd-lg-4 mx-lg-2  px-md-2 py-md-2 py-sm-1 @if(\App\OtvorenRacun::brojRacunaZaSto(2)>0) btn-danger @else btn-light @endif"> @if(\App\OtvorenRacun::brojRacunaZaSto(2)>0) {{\App\OtvorenRacun::ukupnoZaSto(2)}} @else Sto 2 @endif</a>
            </div>
        </div>
        <div id="stolovi3" class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <div class="row">
                <a id="sto8"@if(\App\OtvorenRacun::brojRacunaZaSto(8)>0) href="{{route('editKasa',8)}}" @else href="{{route('createKasa',8)}}" @endif class="sto btn  my-lg-4 my-md-4 my-sm-2 px-md-2 px-lg-4 py-lg-4 py-md-2 px-sm-1 py-sm-1   @if(\App\OtvorenRacun::brojRacunaZaSto(8)>0) btn-danger @else btn-light @endif"> @if(\App\OtvorenRacun::brojRacunaZaSto(8)>0) {{\App\OtvorenRacun::ukupnoZaSto(8)}} @else Sto 8 @endif</a>
            </div>
            <div class="row">
                <a id="sto9" @if(\App\OtvorenRacun::brojRacunaZaSto(7)>0) href="{{route('editKasa',7)}}" @else href="{{route('createKasa',7)}}" @endif class="sto btn btn  my-lg-4 my-md-4 my-sm-2 px-md-2 px-lg-4 py-lg-4 py-md-2 px-sm-1 py-sm-1 @if(\App\OtvorenRacun::brojRacunaZaSto(7)>0) btn-danger @else btn-light @endif"> @if(\App\OtvorenRacun::brojRacunaZaSto(7)>0) {{\App\OtvorenRacun::ukupnoZaSto(7)}} @else Sto 7 @endif</a>
            </div>
        </div>
        <div id="stolovi4"  class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <div class="row">
                <a id="sto10" @if(\App\OtvorenRacun::brojRacunaZaSto(6)>0) href="{{route('editKasa',6)}}" @else href="{{route('createKasa',6)}}" @endif class="sto btn mt-lg-1 mb-lg-3  px-md-2 px-lg-4 py-lg-4 py-md-2 px-sm-1 py-sm-1   @if(\App\OtvorenRacun::brojRacunaZaSto(6)>0) btn-danger @else btn-light @endif"> @if(\App\OtvorenRacun::brojRacunaZaSto(6)>0) {{\App\OtvorenRacun::ukupnoZaSto(6)}} @else Sto 6 @endif</a>
            </div>
            <div class="row">
                <a id="sto11" @if(\App\OtvorenRacun::brojRacunaZaSto(5)>0) href="{{route('editKasa',5)}}" @else href="{{route('createKasa',5)}}" @endif class="sto btn btn mt-lg-1 mb-lg-3  px-md-2 px-lg-4 py-lg-4 py-md-2 px-sm-1 py-sm-1 @if(\App\OtvorenRacun::brojRacunaZaSto(5)>0) btn-danger @else btn-light @endif"> @if(\App\OtvorenRacun::brojRacunaZaSto(5)>0) {{\App\OtvorenRacun::ukupnoZaSto(5)}} @else Sto 5 @endif</a>
            </div>
            <div class="row">
                <a id="sto12" @if(\App\OtvorenRacun::brojRacunaZaSto(4)>0) href="{{route('editKasa',4)}}" @else href="{{route('createKasa',4)}}" @endif class="sto btn mt-lg-1 mb-lg-3 px-md-2 px-lg-4 py-lg-4 py-md-2 px-sm-1 py-sm-1   @if(\App\OtvorenRacun::brojRacunaZaSto(4)>0) btn-danger @else btn-light @endif"> @if(\App\OtvorenRacun::brojRacunaZaSto(4)>0) {{\App\OtvorenRacun::ukupnoZaSto(4)}} @else Sto 4 @endif</a>
            </div>
            <div class="row">
                <a id="sto13" @if(\App\OtvorenRacun::brojRacunaZaSto(3)>0) href="{{route('editKasa',3)}}" @else href="{{route('createKasa',3)}}" @endif class="sto btn btn mt-lg-1 mb-lg-3  px-md-2 px-lg-4 py-lg-4 py-md-2 px-sm-1 py-sm-1 @if(\App\OtvorenRacun::brojRacunaZaSto(3)>0) btn-danger @else btn-light @endif"> @if(\App\OtvorenRacun::brojRacunaZaSto(3)>0) {{\App\OtvorenRacun::ukupnoZaSto(3)}} @else Sto 3 @endif</a>
            </div>
        </div>
        <div id="linkovi" class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="dugmici row-cols-1"><a href="{{route('indexArtikal')}}" class="btn  btn-info btn-block my-lg-4 my-md-2 my-sm-1 px-md-1 py-lg-3 py-md-1 px-sm-0 py-sm-0"><span class="tekst  text-black-50">Artikli</span></a></div>
            <div class="dugmici row-cols-1"><a href="{{route('indexKategorija')}}" class="btn btn-info btn-block my-lg-4 my-md-2 my-sm-1  px-md-1 py-lg-3 py-md-1 px-sm-0 py-sm-0"><span class="tekst text-black-50">Prodaja konobara</span></a></div>
            @can('admin')
                <div class="dugmici row-cols-1"><a href="{{route('indexKategorija')}}" class="btn btn-info btn-block my-lg-4 my-md-2 my-sm-1 px-md-1 py-lg-3 py-md-1 px-sm-0 py-sm-0"><span class="tekst text-black-50">Prodaja svih konobara</span></a></div>
                <div class="dugmici row-cols-1"><a href="{{route('indexKategorija')}}" class="btn btn-info btn-block my-lg-4 my-md-2 my-sm-1 px-md-1 py-lg-3 py-md-1 px-sm-0 py-sm-0"><span class="tekst text-black-50">Administracija</span></a></div>
            @endcan
            <div class="dugmici row-cols-1"><a href="{{route('indexKategorija')}}" class="btn btn-info btn-block my-lg-4 my-md-2 my-sm-1 px-md-1 py-lg-3 py-md-1 px-sm-0 py-sm-0"><span class="tekst text-black-50">Predracuni</span></a></div>
            @can('admin')
                <div class="dugmici row-cols-1"><a href="{{route('indexFirma')}}" class="btn btn-info btn-block my-lg-4 my-md-2 my-sm-1 px-md-1 py-lg-3 py-md-1 px-sm-0 py-sm-0"><span class="tekst text-black-50">Firma</span></a></div>
                <div class="dugmici row-cols-1"><a href="{{route('register')}}" class="btn btn-info btn-block my-lg-4 my-md-2 my-sm-1 px-md-1 py-lg-3 py-md-1 px-sm-0 py-sm-0"><span class="tekst text-black-50">Korisnici</span></a></div>
                <div class="dugmici row-cols-1"><a href="{{route('indexKategorija')}}" class="btn btn-info btn-block my-lg-4 my-md-2 my-sm-1 px-md-1 py-lg-3 py-md-1 px-sm-0 py-sm-0"><span class="tekst text-black-50">Fiskalni izvestaji</span></a></div>
            @endcan

        </div>
        <form action="{{route('logout')}}" method="POST">
            @csrf
            <button type="submit" id="logout" class="btn btn-danger">Kraj rada</button>
        </form>
    </div>
@endsection

