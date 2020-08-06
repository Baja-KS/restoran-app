@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <div class="container-fluid">
        <form action="{{route('updateArtikal',$artikal->PLUKod)}}" method="POST">
            @csrf
            @method('PATCH')
            <h2>Izmeni artikal</h2>
            <hr>
            <div class="col-md-2">
                <div class="form-group">
                    <div>
                        <label for="naziv" class="col-form-label">Naziv artikla*</label>
                        <input id="naziv" type="text" class="form-control @error('naziv') is-invalid @enderror" name="naziv" value="{{ $artikal->Naziv }}" required autocomplete="naziv" autofocus>
                    </div>
                    <div>
                        <label for="kategorija" class="col-form-label">Kategorija*</label>
                        <select id="kategorija" required class="form-control dropdown" name="kategorija">
                            <option selected disabled value="">Izaberi Kategoriju</option>
                            @foreach($kategorije as $kategorija)
                                <option value="{{$kategorija->SifKat}}" @if($artikal->podkategorija==$kategorija) selected @endif>{{$kategorija->Naziv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="grupa" class="col-form-label">Grupa</label>
                        <select id="grupa"   class="form-control dropstatic" disabled  name="grupa">
                            <option id="grupaStavka[]" class="defopcija" selected disabled value="">Grupa</option>
                            @foreach($grupe as $grupa)
                                <option value="{{$grupa->SifKat}}"  @if($artikal->podkategorija->glavnaKategorija==$grupa) selected @endif>{{$grupa->Naziv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="jedinicamere" class="col-form-label">Jedinica Mere*</label>
                        <select id="jedinicamere" required class="form-control dropdown" name="jedinicamere">
                            <option selected disabled value="">Izaberi jedinicu mere</option>
                            @foreach($jedinicemere as $jedinicamere)
                                <option value="{{$jedinicamere->JMID}}" @if($artikal->jedinicamere==$jedinicamere) selected @endif>{{$jedinicamere->Naziv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="poreskastopa"  class="col-form-label">Poreska Stopa*</label>
                        <select id="poreskastopa" required class="form-control dropdown" name="poreskastopa">
                            <option selected disabled value="">Izaberi poresku stopu</option>
                            @foreach($poreskestope as $poreskastopa)
                                <option value="{{$poreskastopa->Sifra}}" @if($artikal->poreskastopa==$poreskastopa) selected @endif>{{$poreskastopa->Opis}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="prodavnica" class="col-form-label">Prodavnica*</label>
                        <input id="prodavnica" type="text" class="form-control @error('prodavnica') is-invalid @enderror" name="prodavnica" value="{{ $artikal->magacin->Prodavnica }}" disabled required autocomplete="naziv" autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div>
                        <label for="kolicinaulaza" class="col-form-label">Kolicina Ulaza</label>
                        <input id="kolicinaulaza" type="number" min="0" step="0.01" class="form-control @error('kolicinaulaza') is-invalid @enderror" disabled name="kolicinaulaza" value="{{ $artikal->magacin->KolicinaUlaza }}">
                    </div>
                    <div>
                        <label for="kolicinaizlaza" class="col-form-label">Kolicina Izlaza</label>
                        <input id="kolicinaizlaza" type="number" min="0" step="0.01" class="form-control @error('kolicinaizlaza') is-invalid @enderror" disabled name="kolicinaizlaza" value="{{ $artikal->magacin->KolicinaIzlaza }}">
                    </div>
                    <div>
                        <label for="zadnjaprodajnacena" class="col-form-label">Zadnja Prodajna Cena</label>
                        <input id="zadnjaprodajnacena" min="0"  type="number" step="0.1" class="form-control @error('zadnjaprodajnacena') is-invalid @enderror" disabled name="zadnjaprodajnacena" value="{{ $artikal->magacin->ZadnjaProdajnaCena }}">
                    </div>
                    <div>
                        <label for="zadnjanabavnacena" class="col-form-label">Zadnja Nabavna Cena</label>
                        <input id="zadnjanabavnacena" type="number" min="0" step="0.1" class="form-control @error('zadnjanabavnacena') is-invalid @enderror" disabled name="zadnjanabavnacena" value="{{ $artikal->magacin->ZadnjaNabavnaCena }}">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div>
                        <label for="normativ" class=" col-form-label">Normativ</label>
                        <input id="normativ" type="checkbox" name="normativ" class="form-control form-check" value="1" @if($artikal->Normativ) checked @endif>
                    </div>
                    <div>
                        <label for="aktivan" class=" col-form-label">Aktivan</label>
                        <input id="aktivan" type="checkbox" name="aktivan" class="form-control form-check" value="1" @if($artikal->Aktivan) checked @endif>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <table class="table table-borderless" id="tabelakomponenti">
                        <thead>
                        <tr>
                            <th>Naziv komponente</th>
                            <th>Kolicina</th>
                            <th><button type="button" class="btn btn-success btn-sm" id="btnadd">+</button></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($artikal->komponente as $komponenta)
                                <tr>
                                    <td><select required class="form-control dropdown" name="komponenta[]"><option selected disabled value="">Izaberi komponentu</option> @foreach($artikli->where('Normativ',false) as $kartikal)<option value="{{$kartikal->PLUKod}}" @if($komponenta->PLUKod==$kartikal->PLUKod) selected @endif>{{$kartikal->Naziv}}</option> @endforeach </select></td>
                                    <td><input required type="number" class="form-control" min="0" step="0.01" name="kolicina[]" value="{{\App\Artikal::kolicinaUMesavini($artikal,$komponenta)}}"></td>
                                    <td><button type="button" class="btn btn-danger btnremove btn-sm">-</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="submit" class="btn btn-info">Azuriraj artikal</button>
            <a href="{{route('indexArtikal')}}" class="btn btn-warning">Nazad</a>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            let normativ=$("#normativ");
            let tabela=$("#tabelakomponenti");
            let jedinicamere = $("#jedinicamere");
            let grupa=$("#grupa")
            let kategorija = $("#kategorija");
            if (normativ.is(':checked')) {
                jedinicamere.val({{$kom->JMID}})
                jedinicamere.prop('disabled',true);
            }
            else {
                tabela.hide()
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
                    tabela.show();
                    jedinicamere.val({{$kom->JMID}})
                    jedinicamere.prop('disabled',true);
                }
                else
                {
                    jedinicamere.prop('disabled',false);
                }
            });
            $(document).on('click','#btnadd',function () {
                var html='';
                html+='<tr>';
                html+='<td><select required class="form-control dropdown" name="komponenta[]"><option selected disabled value="">Izaberi komponentu</option> @foreach($artikli->where('Normativ',false) as $kartikal)<option value="{{$kartikal->PLUKod}}">{{$kartikal->Naziv}}</option> @endforeach </select></td>';
                html+='<td><input required type="number" min="0" step="0.01" class="form-control" name="kolicina[]"></td>';
                html+='<td><button type="button" class="btn btn-danger btnremove btn-sm">-</button></td>';
                html+='</tr>';
                $('#tabelakomponenti').append(html);
                $(".dropdown").select2();
            })
            $(document).on('click','.btnremove',function () {
                $(this).closest('tr').remove()
            })
        })
    </script>
@endsection
