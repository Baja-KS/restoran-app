@extends('administracija.base')

@section('tab-content')
    <div class="col-md-6 justify-content-lg-start px-lg-5">
        <h2 class="text-light">Komitenti</h2>
        <hr>
        <table class="table table-borderless text-light">
            @if($komitenti->count()>0)
            <thead>
                <tr>
                  <th>Naziv</th>
                    <th>Adresa</th>
                    <th>PIB</th>
                </tr>
            </thead>
            @endif
            @forelse($komitenti as $komitent)
                <tr>
                    <td><a href="{{route('showKomitent',$komitent->Sifra)}}" class=""><h4>{{$komitent->Naziv}}</h4></a></td>
                    <td><h4>{{$komitent->Adresa}}</h4></td>
                    <td><h4>{{$komitent->PIB}}</h4></td>
                    <td><a href="{{route('editKomitent',$komitent->Sifra)}}" class="btn btn-warning">Edit</a></td>
                    <td><form action="{{route('destroyKomitent',$komitent->Sifra)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form></td>
                </tr>
            @empty
                <p>Nema nijednog komitenta</p>
            @endforelse
        </table>
        <a href="{{route('createKomitent')}}" class="btn btn-info">Dodaj komitenta</a>
    </div>

@endsection
