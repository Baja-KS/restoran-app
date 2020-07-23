@extends('layouts.welcome')

@section('content')
    <div class="container-fluid">
        <form action="{{route('storeArtikal')}}" method="POST">
            @csrf
            <h2>Dodaj novi artikal</h2>
            <hr>
            <div class="col-md-2">
                <div class="form-group">
                    <div>
                        <label for="naziv" class="col-form-label">Naziv artikla*</label>
                        <input id="naziv" type="text" class="form-control @error('naziv') is-invalid @enderror" name="naziv" value="{{ old('naziv') }}" required autocomplete="naziv" autofocus>
                    </div>
                    <div>
                        <label for="kategorija" class="col-form-label">Kategorija</label>
                        <select id="kategorija"  class="form-control dropdown" name="kategorija">
                            <option value="">Izaberi Kategoriju</option>
                            @foreach($kategorije as $kategorija)
                                <option value="{{$kategorija->SifKat}}">{{$kategorija->Naziv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="jedinicamere" class="col-form-label">Jedinica Mere</label>
                        <select id="jedinicamere"  class="form-control dropdown" name="jedinicamere">
                            <option value="">Izaberi jedinicu mere</option>
                            @foreach($jedinicemere as $jedinicamere)
                                <option value="{{$jedinicamere->JMID}}">{{$jedinicamere->Naziv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="poreskastopa" class="col-form-label">Poreska Stopa</label>
                        <select id="poreskastopa"  class="form-control dropdown" name="poreskastopa">
                            <option value="">Izaberi poresku stopu</option>
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
                        <label for="kolicinaulaza" class="col-form-label">Kolicina Ulaza</label>
                        <input id="kolicinaulaza" type="number" min="0" step="0.01" class="form-control @error('kolicinaulaza') is-invalid @enderror" name="kolicinaulaza" value="{{ old('kolicinaulaza') ?? 0 }}">
                    </div>
                    <div>
                        <label for="kolicinaizlaza" class="col-form-label">Kolicina Izlaza</label>
                        <input id="kolicinaizlaza" type="number" min="0" step="0.01" class="form-control @error('kolicinaizlaza') is-invalid @enderror" name="kolicinaizlaza" value="{{ old('kolicinaizlaza') ?? 0 }}">
                    </div>
                    <div>
                        <label for="zadnjaprodajnacena" class="col-form-label">Zadnja Prodajna Cena</label>
                        <input id="zadnjaprodajnacena" type="number" min="0" step="0.1" class="form-control @error('zadnjaprodajnacena') is-invalid @enderror" name="zadnjaprodajnacena" value="{{ old('zadnjaprodajnacena') ?? 0 }}">
                    </div>
                    <div>
                        <label for="zadnjanabavnacena" class="col-form-label">Zadnja Nabavna Cena</label>
                        <input id="zadnjanabavnacena" type="number" min="0" step="0.1" class="form-control @error('zadnjanabavnacena') is-invalid @enderror" name="zadnjanabavnacena" value="{{ old('zadnjanabavnacena') ?? 0 }}">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div>
                        <label for="normativ" class=" col-form-label">Normativ</label>
                        <input id="normativ" type="checkbox" name="normativ" class="form-control form-check" value="1">
                    </div>
                    <div>
                        <label for="aktivan" class=" col-form-label">Aktivan</label>
                        <input id="aktivan" type="checkbox" name="aktivan" class="form-control form-check" value="1">
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

                        </tbody>
                    </table>
                </div>
            </div>
            <button type="submit" class="btn btn-info">Dodaj artikal</button>
            <a href="{{route('indexArtikal')}}" class="btn btn-warning">Nazad</a>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            // $(".dropdown").select2()
            let normativ=$("#normativ");
            let tabela=$("#tabelakomponenti");
            if (normativ.is(':checked'))
                tabela.show();
            else
                tabela.hide()

            normativ.change(function () {
                tabela.toggle();
            });
            $(document).on('click','#btnadd',function () {
                var html='';
                html+='<tr>';
                html+='<td><select class="form-control dropdown" name="komponenta[]"><option value="">Izaberi komponentu</option> @foreach($artikli->where('Normativ',false) as $artikal)<option value="{{$artikal->PLUKod}}">{{$artikal->Naziv}}</option> @endforeach </select></td>';
                html+='<td><input type="number" class="form-control" min="0" step="0.01" name="kolicina[]"></td>';
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
