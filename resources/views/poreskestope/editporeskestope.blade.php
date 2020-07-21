@extends('layouts.welcome')

@section('content')
    <div class="col-md-6">
        <form action="{{route('updatePoreskastopa',$poreskastopa->Sifra)}}" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <div>
                    <label for="opis" class="col-form-label">Opis poreske stope*</label>
                    <input id="opis" type="text" class="form-control @error('opis') is-invalid @enderror" name="opis" value="{{ $poreskastopa->Opis }}" required autocomplete="opis" autofocus>
                </div>
                <div>
                    <label for="vrednost" class="col-form-label">Vrednost*</label>
                    <input id="vrednost" type="text" class="form-control @error('vrednost') is-invalid @enderror" name="vrednost" value="{{ $poreskastopa->Vrednost }}" required autocomplete="vrednost" autofocus><span>%</span>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Izmeni poresku stopu</button>
        </form>
        <a href="{{route('indexPoreskastopa')}}" class="btn btn-warning">Nazad</a>
    </div>
@endsection
