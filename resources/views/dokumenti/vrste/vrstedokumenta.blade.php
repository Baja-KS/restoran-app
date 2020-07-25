@extends('layouts.welcome')

@section('content')
    <div class="col-md-6 justify-content-lg-start px-lg-5">
        <h2>Vrste dokumenta</h2>
        <hr>
        <table class="table table-borderless">
            @if($vrstedokumenta->count()>0)
                <thead>
                <tr>
                    <th>Modul</th>
                    <th>Sifra</th>
                    <th>UI</th>
                    <th>Opis</th>
                    <th>PDV</th>
                    <th>MP/VP</th>
                </tr>
                </thead>
            @endif
            @forelse($vrstedokumenta as $vrstadokumenta)
                <tr>
                    <td><h4>{{$vrstadokumenta->Modul}}</h4></td>
                    <td><h4>{{$vrstadokumenta->Sifra}}</h4></td>
                    <td><h4>{{$vrstadokumenta->UI}}</h4></td>
                    <td><h4>{{$vrstadokumenta->Opis}}</h4></td>
                    <td><h4>{{$vrstadokumenta->PDV ? "Da" : "Ne"}}</h4></td>
                    <td><h4>{{$vrstadokumenta->MPVP}}</h4></td>
                    <td><a href="{{route('editVrstadokumenta',$vrstadokumenta->id)}}" class="btn btn-warning">Edit</a></td>
                    <td><form action="{{route('destroyVrstadokumenta',$vrstadokumenta->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form></td>
                </tr>
            @empty
                <p>Nema dodatih vrsta dokumenta</p>
            @endforelse
        </table>
        {{$vrstedokumenta->links()}}
        <a href="{{route('createVrstadokumenta')}}" class="btn btn-info">Dodaj vrstu</a>
        <a href="{{route('home')}}" class="btn btn-warning">Nazad</a>
    </div>

@endsection
