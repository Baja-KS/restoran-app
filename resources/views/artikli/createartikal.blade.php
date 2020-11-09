@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <div class="container-fluid">
        <form action="{{route('storeArtikal')}}" method="POST">
            @csrf
            <h2 class="text-light">Dodaj novi artikal</h2>
            <hr>
            <div class="container-fluid" style="background-color: saddlebrown">
                <div class="col-md-2">
                    <div class="form-group">
                        <div>
                            <label for="naziv" class="col-form-label text-light">Naziv artikla*</label>
                            <input id="naziv" type="text" class=" text-lightform-control @error('naziv') is-invalid @enderror" name="naziv" value="{{ old('naziv') }}" required autocomplete="naziv" autofocus>
                        </div>
                        <div>
                            <label for="kategorija" class="col-form-label text-light">Kategorija</label>
                            <select id="kategorija"  class="form-control  dropstatic" name="kategorija" required>
                                <option class="defopcija" selected disabled value="">Izaberi Kategoriju</option>
                                @foreach($kategorije as $kategorija)
                                    <option value="{{$kategorija->SifKat}}">{{$kategorija->Naziv}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="grupa" class="col-form-label text-light">Grupa</label>
                            <select id="grupa"   class="form-control dropstatic" disabled  name="grupa">
                                <option id="grupaStavka[]" class="defopcija" selected disabled value="">Grupa</option>
                                @foreach($grupe as $grupa)
                                    <option value="{{$grupa->SifKat}}">{{$grupa->Naziv}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="jedinicamere" class="col-form-label text-light">Jedinica Mere</label>
                            <select id="jedinicamere"  class="form-control  dropstatic" name="jedinicamere" required>
                                <option class="defopcija" selected disabled value="">Izaberi jedinicu mere</option>
                                @foreach($jedinicemere as $jedinicamere)
                                    <option value="{{$jedinicamere->JMID}}">{{$jedinicamere->Naziv}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="poreskastopa" class="col-form-label text-light">Poreska Stopa</label>
                            <select id="poreskastopa"  class="form-control  dropstatic" name="poreskastopa" required>
                                <option class="defopcija" selected disabled value="">Izaberi poresku stopu</option>
                                @foreach($poreskestope as $poreskastopa)
                                    <option value="{{$poreskastopa->Sifra}}">{{$poreskastopa->Opis}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div>
                            <label for="normativ" class=" col-form-label text-light">Normativ</label>
                            <input id="normativ" type="checkbox" name="normativ" class="form-control form-check" value="1">
                        </div>
                        <div>
                            <label for="aktivan" class=" col-form-label text-light">Aktivan</label>
                            <input id="aktivan" type="checkbox" name="aktivan" class="form-control form-check" value="1">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <table class="table table-borderless" id="tabelakomponenti">
                            <thead>
                            <tr>
                                <th class="text-light">Naziv komponente</th>
                                <th class="text-light">Kolicina</th>
                                <th><button type="button" class="btn btn-success btn-sm" id="btnadd">+</button></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-info">Dodaj artikal</button>
            <a href="{{route('indexArtikal')}}" class="btn btn-warning">Nazad</a>
        </form>
    </div>
    <script>
        /*$(document).on('change','#kategorija',function (){
            $.ajax({
                type:'GET',
                url:{{route('showGrupa')}},
                data:{
                    _token:{{csrf_token()}},
                    kategorija:$("#kategorija").val()
                },
                success:function (data) {
                    $("#grupa").val(data.SifKat)
                }
            })
        })*/
        $(document).ready(function () {
            let normativ=$("#normativ");
            let tabela=$("#tabelakomponenti");
            let jedinicamere = $("#jedinicamere");
            let grupa=$("#grupa")
            let kategorija = $("#kategorija");
            if (normativ.is(':checked')) {
                tabela.show();
                jedinicamere.val({{$kom->JMID}})
                jedinicamere.prop('disabled',true);
            }
            else {
                tabela.hide()
                jedinicamere.val("")
                jedinicamere.prop('disabled',false);
            }
            kategorija.change(function (e){
                $.ajax({
                    url:'{{route('showGrupa')}}',
                    method:'get',
                    data:{
                      kategorija:kategorija.val()
                    },
                    success:function (data)
                    {
                        grupa.val(data.grupa)
                    }
                })
            })


            normativ.change(function () {
                tabela.toggle();
                if (normativ.is(':checked')) {
                    jedinicamere.val({{$kom->JMID}})
                    jedinicamere.prop('disabled',true);
                }
                else
                {
                    jedinicamere.val("")
                    jedinicamere.prop('disabled',false);
                }

            });
            $(document).on('click','#btnadd',function () {
                var html='';
                html+='<tr>';
                html+='<td><select class="form-control dropdown" required name="komponenta[]"><option selected disabled class="defopcija" value="">Izaberi komponentu</option> @foreach($artikli->where('Normativ',false) as $artikal)<option value="{{$artikal->PLUKod}}">{{$artikal->Naziv}}</option> @endforeach </select></td>';
                html+='<td><input required type="number" class="form-control" min="0" step="0.01" name="kolicina[]"></td>';
                html+='<td><button type="button" class="btn btn-danger btnremove btn-sm">-</button></td>';
                html+='</tr>';
                $('#tabelakomponenti').append(html);
                $(".dropdown").select2();
                // $(".dropdown").change(function () {
                //     $(this>option[value='']).prop('disabled',true)
                // })


            })
            $(document).on('click','.btnremove',function () {
                $(this).closest('tr').remove()
            })
        })
    </script>
@endsection
