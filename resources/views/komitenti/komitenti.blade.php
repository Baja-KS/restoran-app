@extends('layouts.welcome')

@section('content')
    <div class="col-md-6 justify-content-lg-start px-lg-5">
        <h2>Komitenti</h2>
        <hr>
        <table>
            @forelse($komitenti as $komitent)
                <tr>
                    <td><a href="{{route('showKomitenta',$komitent->Sifra)}}" class=""><h4>{{$komitent->Naziv}}</h4></a></td>
                    <td><a href="{{route('editKomitenta',$komitent->Sifra)}}" class="btn btn-warning">Edit</a></td>
                    <td><form action="{{route('deleteKomitenta',$komitent->Sifra)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form></td>
                </tr>
            @empty
                <p>Nema nijednog komitenta</p>
            @endforelse
        </table>
    </div>
    <div class="col-md-6 justify-content-lg-start px-lg-5">
        <h2>Dodaj novog komitenta</h2>
        <hr>
        <form action="{{route('dodajKomitenta')}}" method="POST">
            @csrf
            <div class="form-group">
                <div>
                    <label for="naziv" class="col-md-4 col-form-label text-md-right">Naziv komitenta</label>
                    <input id="naziv" type="text" class="form-control @error('naziv') is-invalid @enderror" name="naziv" value="{{ old('naziv') }}" required autocomplete="naziv" autofocus>
                </div>
                <div>
                    <label for="adresa" class="col-md-4 col-form-label text-md-right">Adresa</label>
                    <input id="adresa" type="text" class="form-control @error('naziv') is-invalid @enderror" name="naziv" value="{{ old('naziv') }}" required autocomplete="naziv" autofocus>
                </div>
            </div>
        </form>
    </div>
@endsection
