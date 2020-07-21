@extends('layouts.welcome')

@section('content')
    <div class="container-fluid">
    <div class="col-md-6 justify-content-lg-start px-lg-5">
        <h2>Poreske stope</h2>
        <hr>
        <table class="table table-borderless">
            @if(count($poreskestope)>0)
            <thead>
            <tr>
                <th>Sifra</th>
                <th>Opis</th>
                <th>Vrednost</th>
            </tr>
            </thead>
            @endif
            @forelse($poreskestope as $poreskastopa)
                <tr>
                    <td><h4>{{$poreskastopa->Sifra}}</h4></td>
                    <td><h4>{{$poreskastopa->Opis}}</h4></td>
                    <td><h4>{{$poreskastopa->Vrednost}}%</h4></td>
                    <td><a href="{{route('editPoreskastopa',$poreskastopa->Sifra)}}" class="btn btn-warning">Edit</a></td>
                    <td><form action="{{route('destroyPoreskastopa',$poreskastopa->Sifra)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form></td>
                </tr>
            @empty
                <p>Nema unetih poreskih stopa</p>
            @endforelse
        </table>
    </div>
    <div class="col-md-6">
        <form action="{{route('storePoreskastopa')}}" method="POST">
            @csrf
        <div class="form-group">
            <div>
                <label for="opis" class="col-form-label">Opis poreske stope*</label>
                <input id="opis" type="text" class="form-control @error('opis') is-invalid @enderror" name="opis" value="{{ old('opis') }}" required autocomplete="opis" autofocus>
            </div>
            <div>
                <label for="vrednost" class="col-form-label">Vrednost*</label>
                <input id="vrednost" type="text" class="form-control @error('vrednost') is-invalid @enderror" name="vrednost" value="{{ old('vrednost') }}" required autocomplete="vrednost" autofocus>
            </div>
        </div>
            <button type="submit" class="btn btn-success">Dodaj poresku stopu</button>
        </form>
        <a href="{{route('home')}}" class="btn btn-info">Nazad</a>
    </div>
    </div>
@endsection
