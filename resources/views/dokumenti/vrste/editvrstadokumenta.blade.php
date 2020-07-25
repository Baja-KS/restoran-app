@extends('layouts.welcome')

@section('content')
    <div class="container-fluid">
        <form action="{{route('updateVrstadokumenta',$vrstadokumenta->id)}}" method="POST">
            @csrf
            @method('PATCH')
            <h2>Izmeni vrstu dokumenta</h2>
            <hr>
            <div class="col-md-2">
                <div class="form-group">
                    <div>
                        <label for="modul" class="col-form-label">Modul*</label>
                        <input id="modul" type="text" class="form-control @error('modul') is-invalid @enderror" name="modul" value="{{ $vrstadokumenta->Modul }}" required autocomplete="modul" autofocus>
                    </div>
                    <div>
                        <label for="sifra" class="col-form-label">Sifra*</label>
                        <input id="sifra" type="text" class="form-control @error('sifra') is-invalid @enderror" name="sifra" value="{{ $vrstadokumenta->Sifra }}" required autocomplete="sifra" autofocus>
                    </div>
                    <div>
                        <label for="ui" class="col-form-label">UI</label>
                        <select id="ui"  class="form-control dropdown" name="ui">
                            <option value="">Izaberi opciju</option>
                            @foreach($ui as $uistavka)
                                <option value="{{$uistavka}}" @if($uistavka==$vrstadokumenta->UI) selected @endif>{{$uistavka}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="opis" class="col-form-label">Opis*</label>
                        <input id="opis" type="text" class="form-control @error('opis') is-invalid @enderror" name="opis" value="{{ $vrstadokumenta->Opis }}" required autocomplete="opis" autofocus>
                    </div>
                    <div>
                        <label for="mpvp" class="col-form-label">Maloprodaja/Veleprodaja</label>
                        <select id="mpvp"  class="form-control dropdown" name="mpvp">
                            <option value="">Izaberi opciju</option>
                            @foreach($mpvp as $mpvpstavka)
                                <option value="{{$mpvpstavka}}"  @if($mpvpstavka==$vrstadokumenta->MPVP) selected @endif>{{$mpvpstavka}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div>
                        <label for="pdv" class=" col-form-label">PDV</label>
                        <input id="pdv" type="checkbox" name="pdv" class="form-control form-check" value="1" @if($vrstadokumenta->PDV) checked @endif>
                    </div>
                    <div>
                        <label for="autoknj" class=" col-form-label">Automatsko knjizenje</label>
                        <input id="autoknj" type="checkbox" name="autoknj" class="form-control form-check" value="1" @if($vrstadokumenta->AutoKnj) checked @endif>
                    </div>
                    <div>
                        <label for="akkorisnik" class=" col-form-label">Automatsko knjizenje korisnika</label>
                        <input id="akkorisnik" type="checkbox" name="akkorisnik" class="form-control form-check" value="1" @if($vrstadokumenta->AKKorisnik) checked @endif>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-info">Izmeni vrstu dokumenta</button>
            <a href="{{route('indexVrstadokumenta')}}" class="btn btn-warning">Nazad</a>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            $(".dropdown").select2()
        })
    </script>
@endsection
