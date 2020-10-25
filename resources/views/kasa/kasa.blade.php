@extends('layouts.welcome')

@section('content')
@include('layouts.bezstolova')
<style>

    .kategorije{
        display: inline-flex;
        justify-content: flex-start;
        flex-wrap: wrap;
        max-width: 100%;
        max-height: 30%;
        left: 0%;
    }
    .artikli {
        display: flex;
        justify-content: flex-start;
        align-content:flex-start;
        flex-wrap: wrap;
        flex-direction:column;
        max-height:55vh;
    }
    .bottomContainer {
        display: inline-flex;
        justify-content: flex-start;
    }
    .tastaturaNaplata {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-content: stretch;
    }
    #gostlabel {
        display: flex;
        flex-direction: row;

    }
    .tastatura {
        display: grid;
        grid-template-rows: repeat(9,40px);
        grid-template-columns: repeat(4,25%);
        justify-content: center;
    }
    /*#kolicina {
        width: 125%;
        href="route('createKasa',[$sto,$kategorija->SifKat])"
    }*/
    #enter {
        grid-column: 4;
        grid-row-start:1 ;
        grid-row-end: 5;
    }
    table {
        display: block;
        overflow-y: auto;
        overflow-x: hidden;
        height: 45vh;
    }

    @media only screen and (min-width: 970px) and (max-width: 1280px) {
        .btn {
            font-size: smaller;
            padding-top: 1vh !important;
            padding-bottom: 1vh !important;
            padding-left: 1vw !important;
            padding-right: 1vw !important;
        }
        .kategorije {
            width: 50%;
        }
        .artikli {
            width: 45vw;
            height: 40vh;
        }
        @media only screen and (min-width: 1024px) and (max-width:1280px) {
            .artikli {
                width: 40vw;
            }
        }
        #gostlabel {
            width: 50%;
        }
        .bottomContainer {
            width: 50vw;
            height: 30px;
        }
        .bottomContainer input {
            width: 10vw;
            height: 5vh;
        }
        .bottomContainer .btn {
            width: 10vw;
            height: 5vh;
        }
        .tastatura {
            display: grid;
            grid-template-rows: repeat(9,20px);
            grid-template-columns: repeat(4,25%);
            justify-content: center;

        }
        .tastatura button {
            font-size: smaller !important;
        }
        .kategorije .btn {
            font-size: smaller;
            margin: 0 0 0 0 !important;
            padding-top: 1vh !important;
            padding-bottom: 1vh !important;
            padding-left: 1vw !important;
            padding-right: 1vw !important;
        }
        .artikli .btn {
            font-size: smaller;
            margin: 0 0 0 0 !important;
            padding-top: 1vh !important;
            padding-bottom: 1vh !important;
            padding-left: 1vw !important;
            padding-right: 1vw !important;
        }
        .bottomContainer {
            height: 40px;
        }
        table {
            display: block;
            overflow-y: auto;
            overflow-x: hidden;
            height: 40vh;
            width: 10vw;
        }
        tr {
            font-size: smaller;
        }
    }
    @media only screen and (min-width: 500px) and (max-width: 970px){
        .btn {
            font-size: x-small;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        .kategorije {
            width: 50%;
            position: absolute;
            left: 40%;
            top: 5%;
        }
        .artikli {
            position: absolute;
            top: 30vh;
            width: 30vw;
            height: 35vh;
        }
        .artikli .btn {
            font-size: x-small;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        #gostlabel {
            width: 50px;
        }
        .bottomContainer {
            width: 50vw;
            height: 30px;
        }
        .bottomContainer input {
            width: 10vw;
            height: 5vh;
        }
        .bottomContainer .btn {
            width: 10vw;
            height: 5vh;
        }
        .tastatura {
            display: grid;
            grid-template-rows: repeat(9,20px);
            grid-template-columns: repeat(4,20px);
            justify-content: center;

        }
        #stavke p {
            font-size: smaller;
        }
        label {font-size: smaller}
        .tastatura button {
            font-size: smaller !important;
        }
        .kategorije .btn {
            font-size: smaller;
            margin: 0 0 0 0 !important;
        }
        .artikli .btn {
            font-size: smaller;
            margin: 0 0 0 0 !important;
        }
        .bottomContainer {
            height: 40px;
        }
        table {
            display: block;
            overflow-y: auto;
            overflow-x: hidden;
            height: 40vh;
            width: 10vw;
        }
        tr {
            font-size: x-small;
        }
        #leviDeo {
            margin-left: 0;
        }
    }


</style>
<div>
    <form action="{{route('storeKasa',$sto)}}" method="POST">
        @csrf
    <div class="col-lg-10 col-md-10 col-sm-10">
        <div class="row kategorije border border-danger">
            @foreach($kategorije as $kategorija)
                @if($kategorija->glavnaKategorija->Naziv!="Komponente")
                    <span class="btn  btn-warning kategorija mx-lg-2 my-lg-2 mx-md-0 my-md-0 mx-sm-0 my-sm-0"  id="{{$kategorija->SifKat}}">{{$kategorija->Naziv}}</span>
                    <input type="hidden" id="br{{$kategorija->SifKat}}" value="{{$kategorija->artikli->count()}}">
                    @for($i=0;$i<$kategorija->artikli->count();$i++)
                        @if($kategorija->artikli[$i]->Aktivan)
                        <input type="hidden" class="i{{$kategorija->SifKat}}" id="i{{$kategorija->SifKat}}_{{$i}}" value="{{$kategorija->artikli[$i]->PLUKod}}">
                        <input type="hidden" class="n{{$kategorija->SifKat}}"  id="n{{$kategorija->SifKat}}_{{$i}}" value="{{$kategorija->artikli[$i]->Naziv}}">
                        <input type="hidden" class="c{{$kategorija->SifKat}}"  id="c{{$kategorija->SifKat}}_{{$i}}" value="{{$kategorija->artikli[$i]->magacin->ZadnjaProdajnaCena}}">
                        @endif
                    @endfor
                @endif
            @endforeach
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5" id="leviDeo">
            <div id="gostlabel" class="row">
                <label for="gost">Gost:</label>
                <select id="gost"  class="form-control dropdown" @if($edit) disabled @endif name="gost">
                    <option value="" selected>/</option>
                    @foreach($komitenti as $komitent)
                        <option value="{{$komitent->Sifra}}" @if($edit && $racuni[count($racuni)-1]->Gost===$komitent->Sifra)  selected @endif>{{$komitent->Naziv}}</option>
                    @endforeach
                </select>
                @foreach($komitenti as $komitent)
                    <input type="hidden" id="p{{$komitent->Sifra}}" value="{{$komitent->Popust}}">
                @endforeach
            </div>
            <div id="stavke">
                <p class="text text-light">Radnik: {{$radnik->CompleteName}}</p>
                <p class="text text-light">Sto broj {{$sto}}</p>
                <p class="text text-light">Datum i vreme : {{ date('Y-m-d H:i')}}</p>

                <table class="table table-striped table-borderless table-light">
                    @yield('stavke')
                </table>

                <div class="bottomContainer">
                    <p class="btn my-0 py-lg-2 py-md-0 py-sm-0 btn-danger" id="brisisve">Obrisi sve stavke</p>
                    <p class="btn my-0 py-lg-2 py-md-0 py-sm-0 btn-danger" id="brisiizabranu">Obrisi izabranu stavku</p>
{{--                    <input type="hidden" id="bezPopusta" name="bezPopusta" value="">--}}
                    <label class="text-primary font-weight-bold" for="ukupnaCena">Ukupna Cena</label>
                    <input type="text"  id="ukupnaCena" name="ukupnaCena" value="{{$ukupno ?? 0}}" disabled>
                    <label class="text-primary font-weight-bold" for="popust">Popust</label>
                    <input type="text"  id="popust" name="popust" value="">
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7">
            <div class="artikli my-lg-4 border border-danger" id="artikli">

            </div>
            <p class="text-danger font-weight-bold">@if($greska!='edit'){{$greska}}@endif</p>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 tastaturaNaplata">
        <button type="submit" name="akcija" value="poruci" class="btn btn-danger my-lg-5 py-md-0 my-md-0" id="porudzbina">Porudzbina</button>
        @if($edit && count($racuni)>0)
            <button type="submit" class="btn btn-warning py-md-0" name="akcija" value="naplata" id="naplata">Naplata</button>
        @endif
        <input type="text" class="mt-lg-4" id="kolicina"  placeholder="Kolicina">
        <div class="tastatura">
            <p class="btn btn-warning broj " id="1">1</p>
            <p class="btn btn-warning broj" id="2">2</p>
            <p class="btn btn-warning broj" id="3">3</p>
            <span class="btn btn-warning px-lg-1" id="enter">Enter</span>
            <p class="btn btn-warning broj" id="4">4</p>
            <p class="btn btn-warning broj" id="5">5</p>
            <p class="btn btn-warning broj" id="6">6</p>
            <p class="btn btn-warning broj" id="7">7</p>
            <p class="btn btn-warning broj" id="8">8</p>
            <p class="btn btn-warning broj" id="9">9</p>
            <p class="btn btn-warning px-lg-1" id="brisi">Brisi</p>
            <p class="btn btn-warning broj" id="0">0</p>
            <p class="btn btn-warning " id="zarez">.</p>
            <div>
                <label for="napomena">Napomena</label>
                <textarea id="napomena" name="napomena"></textarea>
{{--                <button type="submit" class="btn  my-0 py-md-0 py-lg-1 btn-danger" name="akcija" id="zatvorigotovina" value="zatvorigotovina" style="display: none">Zatvori Gotovinom</button>--}}
{{--                <button type="submit" class="btn  my-0 py-md-0 py-lg-1 btn-danger" name="akcija" id="zatvoricek" value="zatvoricek" style="display: none">Zatvori Cekom</button>--}}
{{--                <button type="submit" class="btn  my-0 py-md-0 py-lg-1 btn-danger" name="akcija" id="zatvorikartica" value="zatvorikartica" style="display: none">Zatvori Karticom</button>--}}
            </div>
        </div>
        <div id="donji">

            <button type="submit" class="btn btn-block py-md-0 my-0 py-lg-2 btn-danger" name="akcija" id="zatvorigotovina" value="zatvorigotovina">Zatvori Racun</button>
            <a href="{{route('home')}}" class="btn btn-block py-md-0 my-0 btn-dark py-lg-2">Zatvori kasu</a>
        </div>
    </div>
    </form>
</div>
<script>
    // $(document).ready(function () {
    //     $("#zatvori").click(function () {
    //         $(this).hide()
    //         $("#zatvorigotovina").show()
    //         $("#zatvorikartica").show()
    //         $("#zatvoricek").show()
    //     })
    // })
</script>
@if($edit)
    <script>
        $(document).ready(function () {
            $("#popust").val({{$racuni->last()->gost->Popust ?? 0}})
        })
    </script>
@endif
<script>
    var it={{$index}}
    var neporuceni=0;
</script>
<script>
    function UkupnaCena() {
        let n=it
        zbir=0
        for (let i=0;i<n;i++)
        {
            zbir+=$("#tr" + i).find('.kolicinastavke').text() * 1.00 * $("#tr" + i).find('.cena').text()
        }
        $("#ukupnaCena").val(zbir)
    }
    function popustSve(svi0=false) {
        let n=it
        let popust=$("#popust").val()
        if (svi0)
            popust=0
        for (let i=0;i<n;i++)
        {
            let zaIzmenu=$("#tr"+i)
            let bez=zaIzmenu.find('.cenabezpopusta').val()
            let sapopustom=bez-(popust/100*bez)
            zaIzmenu.find('.cena').text(sapopustom)
            zaIzmenu.find('.popuststavke').val(popust)
        }
        UkupnaCena()
    }
    function popust(novi=false)
    {
        let popust=$("#popust").val()
        let zaIzmenu = $(".selected");
        if (novi)
            zaIzmenu=$(".novi");
        let bez=zaIzmenu.find('.cenabezpopusta').val()
        let sapopustom=bez-(popust/100*bez)
        zaIzmenu.find('.cena').text(sapopustom)
        zaIzmenu.find('.popuststavke').val(popust)
        UkupnaCena()
    }
</script>
<script>

    $(document).ready(function () {
        $("input").focus(function (){
            $(".fokusiran").removeClass('fokusiran')
            $(this).addClass('fokusiran')
        })
        $(".broj").click(function (){
            let broj=$(this).attr('id')
            let fokusirano=$(".fokusiran")
            let trenutni=fokusirano.val()
            let novi=""+trenutni+broj
            fokusirano.val(novi)
            fokusirano.focus()
            popust()
        })
        $("#brisi").click(function (){
            let fokusirano=$(".fokusiran")
            let trenutni=fokusirano.val()
            let novi=trenutni.substring(0,trenutni.length-1)
            fokusirano.val(novi)
            fokusirano.focus()
            popust()
        })
        $("#zarez").click(function (){
            let fokusirano=$(".fokusiran")
            let trenutni=fokusirano.val()
            let novi=trenutni+"."
            fokusirano.val(novi)
            fokusirano.focus()
        })
    })
</script>

<script>
    let gost = $("#gost");
    gost.change(function (e){
        if (gost.val()!="")
        {
            let id=$(this).val()
            let popust=$("#p"+id).val()
            $("#popust").val(popust)
            // $("#popust").prop('disabled',true)
        }
        else
        {
            $("#popust").val(0)
            // $("#popust").prop('disabled',false)
        }
        popustSve()
    })
</script>

<script>
    $(document).ready(function (){
        $('.kategorija').click(function () {
            $("#artikli").empty()
            let katID=$(this).attr('id');
            let brSel="#br"+katID
            let n=$(brSel).val()
            let html=''
            for (let i=0;i<n;i++)
            {
                let idSel="#i"+katID+"_"+i
                let nazivSel="#n"+katID+"_"+i
                let cenaSel="#c"+katID+"_"+i
                let id=$(idSel).val()
                let cena=$(cenaSel).val()
                let naziv=$(nazivSel).val()
                html+='<p class="btn artikal  btn-warning my-lg-2 mx-lg-2 mx-md-0 my-md-0" id="'+id+'">'+naziv+'</p>'
                html+='<input type="hidden" id="ac'+id+'" value="'+cena+'">'
            }
            $("#artikli").append(html)
            $('.artikal').click(function () {
                let id=$(this).attr('id')
                let naziv=$(this).text()
                let cena=$("#ac"+id).val()
                neporuceni++;
                $("#naplata").hide();
                let html='<tr class="racunRed novi" id="tr'+it+'"><td><input type="hidden" class="popuststavke" name="popuststavke[]" value="0"></td><td><input type="hidden" class="cenabezpopusta" id="bp'+it+'" value="'+cena+'"></td><td><input type="hidden" name="stavkaid[]" value="'+id+'"></td><td><input type="hidden" class="stavkakolicina" name="stavkakolicina[]" value="1"></td><td><h6>'+naziv+'</h6></td><td><h6 class="kolicinastavke">1.00</h6></td><td><h6 class="cena">'+cena+'</h6></td></tr>'
                it++
                $("#dodatestavke").append(html)
                UkupnaCena()
                /*let bezPopusta=$("#bezPopusta")
                let ukupnaCena = $("#ukupnaCena");
                let trenutna=(bezPopusta.val())*1.00*/
                cena-=($("#popust").val()/100)*cena
                // bezPopusta.val(trenutna+(cena*1.00))
                popust(true)
                $(".novi").removeClass('novi')
                $(document).on('click','.racunRed',function () {
                    // $(this).closest('tr').remove()
                    if (!$(this).closest('tr').hasClass('unselectable'))
                    {
                        $(".selected").removeClass('selected text-success')
                        $(this).closest('tr').addClass('selected text-success')
                    }
                })
                $("#brisiizabranu").click(function () {
                    /*let kolicina=$(".selected").find('.kolicinastavke').text()*1.00
                    let cenaIzabrane=$(".selected").find('.cena').text()*1.00
                    let trenutna=(bezPopusta.val())*1.00
                    bezPopusta.val(trenutna-(kolicina*cenaIzabrane))*/
                    popust()
                    $(".selected").remove()
                    neporuceni--
                    if(neporuceni<0)
                        neporuceni=0;
                    if(!neporuceni)
                        $("#naplata").show();
                })
                $("#enter").click(function () {
                    let kol = $("#kolicina").val();
                    if (kol!=="")
                    {
                        let starakolicina=$(".selected").find('.kolicinastavke').text()*1.00
                        $(".selected").find('.kolicinastavke').text(kol)
                        $(".selected").find('.stavkakolicina').val(kol)
                       /* let novakolicina=$(".selected").find('.kolicinastavke').text()*1.00
                        let cenaIzabrane=$(".selected").find('.cena').text()*1.00
                        let trenutna=(bezPopusta.val())*1.00
                        bezPopusta.val(trenutna+(novakolicina-starakolicina)*cenaIzabrane)*/
                        popust()
                        $("#kolicina").val("")
                    }
                })
            })
        })
        $("#popust").keyup(function (){
            popust()
        })
    })
</script>
@endsection
