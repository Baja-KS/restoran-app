@extends('administracija.base')

@section('tab-content')
    <style>
        table {
            display: block;
            overflow-y: auto;
            overflow-x: hidden;
            height: 40vh;
        }
        /*#bar {*/
        /*    display: flex;*/
        /*    flex-direction: row;*/
        /*}*/
        #napomenadiv {
            display: flex;
            flex-direction: column;
            height: 10vh;
        }
        #uk {
            display: flex;
            flex-direction: column;
        }
    </style>
    <form method="POST" action="{{$edit ? route('updatePrijemnica',$prijemnica->id) : route('storePrijemnica')}}">
        @csrf
        @if($edit)
            @method('PATCH')
        @endif
        <div class="flex-lg-row">
            <span class="text-light font-weight-bold mx-4">Broj prijemnice: {{$brPrijemnice}}</span>
{{--            $prijemnica->BrDok--}}
            <span class="text-light font-weight-bold mx-4">Datum prijemnice: {{$datumPrijemnice}}</span>
{{--            date_format($prijemnica->created_at,"d/m/Y")--}}
            <div id="uk" class="float-right">
                <label for="nvbp" class="text-light">Nabavna vrednost bez PDV</label>
                <input id="nvbp" disabled value="{{$bezPdv}}">

                <label for="updv" class="text-light">Iznos PDV</label>
                <input id="updv" disabled value="{{$iznosPdv}}">
                {{--        <hr>--}}
                <label for="nvp" class="text-light">Nabavna vrednost sa PDV</label>
                <input id="nvp" disabled value="{{$saPdv}}">
            </div>
        </div>
        <div id="bar" class="col-2 flex-row">
            <br>
            <label for="komitent" class="text-light font-weight-bold mx-4">Dobavljac</label>
            <select id="komitent" @if($edit && $prijemnica->IndikatorKnjizenja) disabled @endif  class="form-control  dropstatic" name="komitent" required>
                <option  disabled value="">Izaberi Dobavljaca</option>
                @foreach($komitenti as $komitent)
                    <option value="{{$komitent->Sifra}}" @if($edit && $prijemnica->SifKom==$komitent->Sifra) selected @endif>{{$komitent->Naziv}}</option>
                @endforeach
            </select>
            <label for="brdok" class="font-weight-bold text-light">Broj dokumenta</label>
            <input name="brdok" id="brdok" @if($edit && $prijemnica->IndikatorKnjizenja) disabled @endif value="{{$edit ? $prijemnica->BrFiskal : ""}}" required>
        </div>
        <div>
            <div class="form-group">
                <table class="table table-borderless" id="tabelakomponenti">
                    <thead>
                    <tr class="font-weight-bold text-light">
                        <th>Sifra</th>
                        <th>Naziv</th>
                        <th>JM</th>
                        <th>Kolicina</th>
                        <th>PDV %</th>
                        <th>NC</th>
                        <th>Rabat %</th>
                        <th>NC sa Rabatom</th>
                        <th>NC bez PDV</th>
                        <th>NC sa PDV</th>
                        @if(!$edit || !$prijemnica->IndikatorKnjizenja)<th><button type="button" class="btn btn-success btn-sm" id="btnadd">+</button></th>@endif
                    </tr>
                    </thead>
                    <tbody>
                    @if($edit)
                        @foreach($prijemnica->stavke as $stavka)
                        <tr>
                            <td><select @if($prijemnica->IndikatorKnjizenja) disabled @endif class="form-control sifra1 dropdown" required name="sifra[]"><option  disabled class="defopcija" value="">Sifra artikla</option> @foreach($artikli as $artikal)<option value="{{$artikal->PLUKod}}" @if($artikal->PLUKod==$stavka->SifraRobe) selected @endif>{{$artikal->PLUKod}}</option> @endforeach </select></td>';
                            <td><select @if($prijemnica->IndikatorKnjizenja) disabled @endif  class="form-control naziv1 dropdown" required ><option disabled class="defopcija" value="">Naziv artikla</option> @foreach($artikli as $artikal)<option value="{{$artikal->PLUKod}}" @if($artikal->PLUKod==$stavka->SifraRobe) selected @endif>{{$artikal->Naziv}}</option> @endforeach </select></td>';
                            <td><input  required type="text" disabled class="jm1 form-control" value="{{$stavka->artikal->jedinicamere->Naziv}}" ></td>
                            <td><input required type="number" @if($prijemnica->IndikatorKnjizenja) disabled @endif class="form-control kolicina1" min="0" step="0.01" name="kolicina[]" value="{{$stavka->Kolicina}}"></td>
                            <td><input   type="number" disabled class="form-control pdv1" min="0" step="0.01" value="{{$stavka->artikal->poreskastopa->Vrednost}}" ></td>
                            <td><input  required type="number" @if($prijemnica->IndikatorKnjizenja) disabled @endif  class="form-control nc1" min="0" step="0.01" name="nc[]" value="{{$stavka->NabCena}}"></td>
                            <td><input required type="number" @if($prijemnica->IndikatorKnjizenja) disabled @endif  class="form-control rabat1" min="0" step="0.01" name="rabat[]" value="{{$stavka->Rabat}}"></td>
                            <td><input  type="number" disabled class="form-control ncsr1" min="0" step="0.01" value="{{$stavka->NabCena-($stavka->Rabat/100)*$stavka->NabCena}}"></td>
                            <td><input  type="number" disabled class="form-control ncbp1" min="0" step="0.01" value="{{$stavka->Kolicina*($stavka->NabCena-($stavka->Rabat/100)*$stavka->NabCena)}}"></td>
                            <td><input  type="number" disabled class="form-control ncp1" min="0" step="0.01" value="{{$stavka->Kolicina*($stavka->NabCena-($stavka->Rabat/100)*$stavka->NabCena)+($stavka->artikal->poreskastopa->Vrednost/100)*($stavka->Kolicina*($stavka->NabCena-($stavka->Rabat/100)*$stavka->NabCena))}}"></td>
                            @if(!$loop->first)
                                <td><button type="button" class="btn btn-danger btnremove1 btn-sm">-</button></td>
                            @endif
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td><select  class="form-control sifra1 dropdown" required name="sifra[]"><option selected disabled class="defopcija" value="">Sifra artikla</option> @foreach($artikli as $artikal)<option value="{{$artikal->PLUKod}}">{{$artikal->PLUKod}}</option> @endforeach </select></td>';
                            <td><select   class="form-control naziv1 dropdown" required ><option selected disabled class="defopcija" value="">Naziv artikla</option> @foreach($artikli as $artikal)<option value="{{$artikal->PLUKod}}">{{$artikal->Naziv}}</option> @endforeach </select></td>';
                            <td><input  required type="text" disabled class="jm1 form-control"  ></td>
                            <td><input required type="number" class="form-control kolicina1" min="0" step="0.01" name="kolicina[]"></td>
                            <td><input   type="number" disabled class="form-control pdv1" min="0" step="0.01" ></td>
                            <td><input  required type="number"  class="form-control nc1" min="0" step="0.01" name="nc[]"></td>
                            <td><input required type="number"  class="form-control rabat1" min="0" step="0.01" name="rabat[]"></td>
                            <td><input  type="number" disabled class="form-control ncsr1" min="0" step="0.01" ></td>
                            <td><input  type="number" disabled class="form-control ncbp1" min="0" step="0.01" ></td>
                            <td><input  type="number" disabled class="form-control ncp1" min="0" step="0.01" ></td>
                            {{--                        <td><button type="button" class="btn btn-danger btnremove btn-sm">-</button></td>--}}
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div id="napomenadiv" class="col-2">
                    <label for="napomena" class="">Napomena</label>
                    <textarea id="napomena" @if($edit && $prijemnica->IndikatorKnjizenja) disabled @endif name="napomena">{{$edit ? $prijemnica->Napomena : ""}}</textarea>
                </div>
                <div class="float-right">
                    <a href="{{route('indexPrijemnica')}}" class="btn btn-warning">Nazad</a>
                    @if(!$edit || !$prijemnica->IndikatorKnjizenja)
                    <button type="submit" name="sub" class="btn btn-success ">@if($edit) Sacuvaj izmenu @else Nova Prijemnica @endif</button>
                    @endif
                </div>
            </div>
        </div>
    </form>
    <script>

        $(document).ready(function (){
            var it=0;
            let nabavnaBezPdv = $("#nvbp");
            // nabavnaBezPdv.val(0);
            let ukPdv = $("#updv");
            // ukPdv.val(0);
            let nabavnaSaPdv = $("#nvp");
            // nabavnaSaPdv.val(0);
            $(".sifra1").change(function () {
                $(this).closest('tr').find('.naziv1').val($(this).val())
                // $(this).closest('tr').find('.jm').val("kom")
                $.ajax({
                    url:'{{route('sifraPromena')}}',
                    method:'get',
                    data:{
                        sifra:$(this).val()
                    },
                    success:(data) => {
                        //uklanjanje starih vrednosti iz zbirova
                        let bp=$(this).closest('tr').find('.ncbp1').val()*1.00
                        let lpdv=$(this).closest('tr').find('.pdv1').val()*1.00
                        let ipdv=bp*(lpdv/100);
                        nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00-bp)
                        ukPdv.val(ukPdv.val()*1.00-ipdv)
                        nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00-(bp+ipdv))
                        //
                        $(this).closest('tr').find('.jm1').val(data.jm)
                        $(this).closest('tr').find('.pdv1').val(data.pdv)
                        let ncbp=$(this).closest('tr').find('.ncbp1').val()*1.00
                        let pdv=data.pdv*1.00
                        let ncp=ncbp+(pdv/100)*ncbp
                        $(this).closest('tr').find('.ncp1').val(ncp)
                        //dodavanje novih vrednosti u zbirove
                        bp=$(this).closest('tr').find('.ncbp1').val()*1.00
                        lpdv=$(this).closest('tr').find('.pdv1').val()*1.00
                        ipdv=bp*(lpdv/100);
                        nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00+bp)
                        ukPdv.val(ukPdv.val()*1.00+ipdv)
                        nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00+(bp+ipdv))
                        //
                    }
                })
            })
            $(".naziv1").change(function () {
                $(this).closest('tr').find('.sifra1').val($(this).val())
                // $(this).closest('tr').find('.jm').val("kom")
                $.ajax({
                    url:'{{route('sifraPromena')}}',
                    method:'get',
                    data:{
                        sifra:$(this).val()
                    },
                    success:(data) => {
                        //uklanjanje starih vrednosti iz zbirova
                        let bp=$(this).closest('tr').find('.ncbp1').val()*1.00
                        let lpdv=$(this).closest('tr').find('.pdv1').val()*1.00
                        let ipdv=bp*(lpdv/100);
                        nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00-bp)
                        ukPdv.val(ukPdv.val()*1.00-ipdv)
                        nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00-(bp+ipdv))
                        //
                        $(this).closest('tr').find('.jm1').val(data.jm)
                        $(this).closest('tr').find('.pdv1').val(data.pdv)
                        let ncbp=$(this).closest('tr').find('.ncbp1').val()*1.00
                        let pdv=data.pdv*1.00
                        let ncp=ncbp+(pdv/100)*ncbp
                        $(this).closest('tr').find('.ncp1').val(ncp)
                        //dodavanje novih vrednosti u zbirove
                        bp=$(this).closest('tr').find('.ncbp1').val()*1.00
                        lpdv=$(this).closest('tr').find('.pdv1').val()*1.00
                        ipdv=bp*(lpdv/100);
                        nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00+bp)
                        ukPdv.val(ukPdv.val()*1.00+ipdv)
                        nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00+(bp+ipdv))
                        //
                    }
                })
            })
            $(".kolicina1").keyup(function () {
                //uklanjanje starih vrednosti iz zbirova
                let bp=$(this).closest('tr').find('.ncbp1').val()*1.00
                let lpdv=$(this).closest('tr').find('.pdv1').val()*1.00
                let ipdv=bp*(lpdv/100);
                nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00-bp)
                ukPdv.val(ukPdv.val()*1.00-ipdv)
                nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00-(bp+ipdv))
                //
                let kol=$(this).val()*1.00
                let ncsr=$(this).closest('tr').find('.ncsr1').val()*1.00
                let ncbp=kol*ncsr;
                let pdv=$(this).closest('tr').find('.pdv1').val()*1.00
                let ncp=ncbp+(pdv/100)*ncbp
                $(this).closest('tr').find('.ncbp1').val(ncbp)
                $(this).closest('tr').find('.ncp1').val(ncp)
                //dodavanje novih vrednosti u zbirove
                bp=$(this).closest('tr').find('.ncbp1').val()*1.00
                lpdv=$(this).closest('tr').find('.pdv1').val()*1.00
                ipdv=bp*(lpdv/100);
                nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00+bp)
                ukPdv.val(ukPdv.val()*1.00+ipdv)
                nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00+(bp+ipdv))
                //
            })
            $(".nc1").keyup(function () {
                //uklanjanje starih vrednosti iz zbirova
                let bp=$(this).closest('tr').find('.ncbp1').val()*1.00
                let lpdv=$(this).closest('tr').find('.pdv1').val()*1.00
                let ipdv=bp*(lpdv/100);
                nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00-bp)
                ukPdv.val(ukPdv.val()*1.00-ipdv)
                nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00-(bp+ipdv))
                //
                let kol=$(this).closest('tr').find('.kolicina1').val()*1.00
                let nc=$(this).val()*1.00
                // let ncsr=$(this).closest('tr').find('.ncsr').val()*1.00
                let rabat=$(this).closest('tr').find('.rabat1').val()*1.00
                let ncsr=nc-(rabat/100)*nc
                let ncbp=kol*ncsr;
                let pdv=$(this).closest('tr').find('.pdv1').val()*1.00
                let ncp=ncbp+(pdv/100)*ncbp
                $(this).closest('tr').find('.ncsr1').val(ncsr)
                $(this).closest('tr').find('.ncbp1').val(ncbp)
                $(this).closest('tr').find('.ncp1').val(ncp)
                //dodavanje novih vrednosti u zbirove
                bp=$(this).closest('tr').find('.ncbp1').val()*1.00
                lpdv=$(this).closest('tr').find('.pdv1').val()*1.00
                ipdv=bp*(lpdv/100);
                nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00+bp)
                ukPdv.val(ukPdv.val()*1.00+ipdv)
                nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00+(bp+ipdv))
                //
            })
            $(".rabat1").keyup(function () {
                //uklanjanje starih vrednosti iz zbirova
                let bp=$(this).closest('tr').find('.ncbp1').val()*1.00
                let lpdv=$(this).closest('tr').find('.pdv1').val()*1.00
                let ipdv=bp*(lpdv/100);
                nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00-bp)
                ukPdv.val(ukPdv.val()*1.00-ipdv)
                nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00-(bp+ipdv))
                //
                let kol=$(this).closest('tr').find('.kolicina1').val()*1.00
                let nc=$(this).closest('tr').find('.nc1').val()*1.00
                // let ncsr=$(this).closest('tr').find('.ncsr').val()*1.00
                let rabat=$(this).val()*1.00
                let ncsr=nc-(rabat/100)*nc
                let ncbp=kol*ncsr;
                let pdv=$(this).closest('tr').find('.pdv1').val()*1.00
                let ncp=ncbp+(pdv/100)*ncbp
                $(this).closest('tr').find('.ncsr1').val(ncsr)
                $(this).closest('tr').find('.ncbp1').val(ncbp)
                $(this).closest('tr').find('.ncp1').val(ncp)
                //dodavanje novih vrednosti u zbirove
                bp=$(this).closest('tr').find('.ncbp1').val()*1.00
                lpdv=$(this).closest('tr').find('.pdv1').val()*1.00
                ipdv=bp*(lpdv/100);
                nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00+bp)
                ukPdv.val(ukPdv.val()*1.00+ipdv)
                nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00+(bp+ipdv))
                //
            })
            $(document).on('click','#btnadd',function () {
                var html='';
                html+='<tr>';
                html+='<td><select id="s'+it+'" class="form-control sifra dropdown" required name="sifra[]"><option selected disabled class="defopcija" value="">Sifra artikla</option> @foreach($artikli as $artikal)<option value="{{$artikal->PLUKod}}">{{$artikal->PLUKod}}</option> @endforeach </select></td>';
                html+='<td><select  id="n'+it+'" class="form-control naziv dropdown" required ><option selected disabled class="defopcija" value="">Naziv artikla</option> @foreach($artikli as $artikal)<option value="{{$artikal->PLUKod}}">{{$artikal->Naziv}}</option> @endforeach </select></td>';
                html+='<td><input id="jm'+it+'" required type="text" disabled class="jm form-control"  ></td>';
                html+='<td><input id="k'+it+'" required type="number" class="form-control kolicina" min="0" step="0.01" name="kolicina[]"></td>';
                html+='<td><input id="pdv'+it+'"  type="number" disabled class="form-control pdv" min="0" step="0.01" ></td>';
                html+='<td><input id="nc'+it+'" required type="number"  class="form-control nc" min="0" step="0.01" name="nc[]"></td>';
                html+='<td><input id="r'+it+'" required type="number"  class="form-control rabat" min="0" step="0.01" name="rabat[]"></td>';
                html+='<td><input id="ncsr'+it+'"  type="number" disabled class="form-control ncsr" min="0" step="0.01" ></td>';
                html+='<td><input id="ncbp'+it+'"  type="number" disabled class="form-control ncbp" min="0" step="0.01" ></td>';
                html+='<td><input id="ncsp'+it+'"  type="number" disabled class="form-control ncp" min="0" step="0.01" ></td>';
                html+='<td><button type="button" class="btn btn-danger btnremove btn-sm">-</button></td>';
                html+='</tr>';
                it++;
                $('#tabelakomponenti').append(html);
                // $(".dropdown").select2();
                // $(".dropdown").change(function () {
                //     $(this>option[value='']).prop('disabled',true)
                // })
                $(".kolicina").keyup(function () {
                    //uklanjanje starih vrednosti iz zbirova
                    let bp=$(this).closest('tr').find('.ncbp').val()*1.00
                    let lpdv=$(this).closest('tr').find('.pdv').val()*1.00
                    let ipdv=bp*(lpdv/100);
                    nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00-bp)
                    ukPdv.val(ukPdv.val()*1.00-ipdv)
                    nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00-(bp+ipdv))
                    //
                    let kol=$(this).val()*1.00
                    let ncsr=$(this).closest('tr').find('.ncsr').val()*1.00
                    let ncbp=kol*ncsr;
                    let pdv=$(this).closest('tr').find('.pdv').val()*1.00
                    let ncp=ncbp+(pdv/100)*ncbp
                    $(this).closest('tr').find('.ncbp').val(ncbp)
                    $(this).closest('tr').find('.ncp').val(ncp)
                    //dodavanje novih vrednosti u zbirove
                    bp=$(this).closest('tr').find('.ncbp').val()*1.00
                    lpdv=$(this).closest('tr').find('.pdv').val()*1.00
                    ipdv=bp*(lpdv/100);
                    nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00+bp)
                    ukPdv.val(ukPdv.val()*1.00+ipdv)
                    nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00+(bp+ipdv))
                    //
                })
                $(".nc").keyup(function () {
                    //uklanjanje starih vrednosti iz zbirova
                    let bp=$(this).closest('tr').find('.ncbp').val()*1.00
                    let lpdv=$(this).closest('tr').find('.pdv').val()*1.00
                    let ipdv=bp*(lpdv/100);
                    nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00-bp)
                    ukPdv.val(ukPdv.val()*1.00-ipdv)
                    nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00-(bp+ipdv))
                    //
                    let kol=$(this).closest('tr').find('.kolicina').val()*1.00
                    let nc=$(this).val()*1.00
                    // let ncsr=$(this).closest('tr').find('.ncsr').val()*1.00
                    let rabat=$(this).closest('tr').find('.rabat').val()*1.00
                    let ncsr=nc-(rabat/100)*nc
                    let ncbp=kol*ncsr;
                    let pdv=$(this).closest('tr').find('.pdv').val()*1.00
                    let ncp=ncbp+(pdv/100)*ncbp
                    $(this).closest('tr').find('.ncsr').val(ncsr)
                    $(this).closest('tr').find('.ncbp').val(ncbp)
                    $(this).closest('tr').find('.ncp').val(ncp)
                    //dodavanje novih vrednosti u zbirove
                    bp=$(this).closest('tr').find('.ncbp').val()*1.00
                    lpdv=$(this).closest('tr').find('.pdv').val()*1.00
                    ipdv=bp*(lpdv/100);
                    nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00+bp)
                    ukPdv.val(ukPdv.val()*1.00+ipdv)
                    nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00+(bp+ipdv))
                    //
                })
                $(".rabat").keyup(function () {
                    //uklanjanje starih vrednosti iz zbirova
                    let bp=$(this).closest('tr').find('.ncbp').val()*1.00
                    let lpdv=$(this).closest('tr').find('.pdv').val()*1.00
                    let ipdv=bp*(lpdv/100);
                    nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00-bp)
                    ukPdv.val(ukPdv.val()*1.00-ipdv)
                    nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00-(bp+ipdv))
                    //
                    let kol=$(this).closest('tr').find('.kolicina').val()*1.00
                    let nc=$(this).closest('tr').find('.nc').val()*1.00
                    // let ncsr=$(this).closest('tr').find('.ncsr').val()*1.00
                    let rabat=$(this).val()*1.00
                    let ncsr=nc-(rabat/100)*nc
                    let ncbp=kol*ncsr;
                    let pdv=$(this).closest('tr').find('.pdv').val()*1.00
                    let ncp=ncbp+(pdv/100)*ncbp
                    $(this).closest('tr').find('.ncsr').val(ncsr)
                    $(this).closest('tr').find('.ncbp').val(ncbp)
                    $(this).closest('tr').find('.ncp').val(ncp)
                    //dodavanje novih vrednosti u zbirove
                    bp=$(this).closest('tr').find('.ncbp').val()*1.00
                    lpdv=$(this).closest('tr').find('.pdv').val()*1.00
                    ipdv=bp*(lpdv/100);
                    nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00+bp)
                    ukPdv.val(ukPdv.val()*1.00+ipdv)
                    nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00+(bp+ipdv))
                    //
                })
                $(".sifra").change(function () {
                    $(this).closest('tr').find('.naziv').val($(this).val())
                    // $(this).closest('tr').find('.jm').val("kom")
                    $.ajax({
                        url:'{{route('sifraPromena')}}',
                        method:'get',
                        data:{
                            sifra:$(this).val()
                        },
                        success:(data) => {
                            //uklanjanje starih vrednosti iz zbirova
                            let bp=$(this).closest('tr').find('.ncbp').val()*1.00
                            let lpdv=$(this).closest('tr').find('.pdv').val()*1.00
                            let ipdv=bp*(lpdv/100);
                            nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00-bp)
                            ukPdv.val(ukPdv.val()*1.00-ipdv)
                            nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00-(bp+ipdv))
                            //
                            $(this).closest('tr').find('.jm').val(data.jm)
                            $(this).closest('tr').find('.pdv').val(data.pdv)
                            let ncbp=$(this).closest('tr').find('.ncbp').val()*1.00
                            let pdv=data.pdv*1.00
                            let ncp=ncbp+(pdv/100)*ncbp
                            $(this).closest('tr').find('.ncp').val(ncp)
                            //dodavanje novih vrednosti u zbirove
                            bp=$(this).closest('tr').find('.ncbp').val()*1.00
                            lpdv=$(this).closest('tr').find('.pdv').val()*1.00
                            ipdv=bp*(lpdv/100);
                            nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00+bp)
                            ukPdv.val(ukPdv.val()*1.00+ipdv)
                            nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00+(bp+ipdv))
                            //
                        }
                    })
                })
                $(".naziv").change(function () {
                    $(this).closest('tr').find('.sifra').val($(this).val())
                    // $(this).closest('tr').find('.jm').val("kom")
                    $.ajax({
                        url:'{{route('sifraPromena')}}',
                        method:'get',
                        data:{
                            sifra:$(this).val()
                        },
                        success:(data) => {
                            //uklanjanje starih vrednosti iz zbirova
                            let bp=$(this).closest('tr').find('.ncbp').val()*1.00
                            let lpdv=$(this).closest('tr').find('.pdv').val()*1.00
                            let ipdv=bp*(lpdv/100);
                            nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00-bp)
                            ukPdv.val(ukPdv.val()*1.00-ipdv)
                            nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00-(bp+ipdv))
                            //
                            $(this).closest('tr').find('.jm').val(data.jm)
                            $(this).closest('tr').find('.pdv').val(data.pdv)
                            let ncbp=$(this).closest('tr').find('.ncbp').val()*1.00
                            let pdv=data.pdv*1.00
                            let ncp=ncbp+(pdv/100)*ncbp
                            $(this).closest('tr').find('.ncp').val(ncp)
                            //dodavanje novih vrednosti u zbirove
                            bp=$(this).closest('tr').find('.ncbp').val()*1.00
                            lpdv=$(this).closest('tr').find('.pdv').val()*1.00
                            ipdv=bp*(lpdv/100);
                            nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00+bp)
                            ukPdv.val(ukPdv.val()*1.00+ipdv)
                            nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00+(bp+ipdv))
                            //
                        }
                    })
                })

            })
            $(document).on('click','.btnremove',function () {
                //uklanjanje starih vrednosti iz zbirova
                let bp=$(this).closest('tr').find('.ncbp').val()*1.00
                let lpdv=$(this).closest('tr').find('.pdv').val()*1.00
                let ipdv=bp*(lpdv/100);
                nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00-bp)
                ukPdv.val(ukPdv.val()*1.00-ipdv)
                nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00-(bp+ipdv))
                //
                $(this).closest('tr').remove()
            })
            $(document).on('click','.btnremove1',function () {
                //uklanjanje starih vrednosti iz zbirova
                let bp=$(this).closest('tr').find('.ncbp1').val()*1.00
                let lpdv=$(this).closest('tr').find('.pdv1').val()*1.00
                let ipdv=bp*(lpdv/100);
                nabavnaBezPdv.val(nabavnaBezPdv.val()*1.00-bp)
                ukPdv.val(ukPdv.val()*1.00-ipdv)
                nabavnaSaPdv.val(nabavnaSaPdv.val()*1.00-(bp+ipdv))
                //
                $(this).closest('tr').remove()
            })

        })
    </script>
@endsection
