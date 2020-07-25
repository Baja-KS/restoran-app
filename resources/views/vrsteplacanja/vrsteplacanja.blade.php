@extends('layouts.welcome')

@section('content')
    <a href="{{route('home')}}" class="btn btn-success">Nazad</a>
    <div class="col-md-4 justify-content-lg-start px-lg-5">
        <h2>Vrste placanja</h2>
        <hr>
        <table class="table table-borderless">
            @if($vrsteplacanja->count()>0)
                <thead>
                <tr>
                   <th>Sifra Placanja</th>
                    <th>Naziv</th>
                </tr>
                </thead>
            @endif
            @forelse($vrsteplacanja as $vrstaplacanja)
                <tr>
                    <td><h4>{{$vrstaplacanja->VrstaPlacanja}}</h4></td>
                    <td><h4>{{$vrstaplacanja->Naziv}}</h4></td>
                    <td><a href="{{route('editVrstaplacanja',$vrstaplacanja->VrstaPlacanja)}}" class="btn btn-warning">Edit</a></td>
                    <td><form action="{{route('destroyVrstaplacanja',$vrstaplacanja->VrstaPlacanja)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form></td>
                </tr>
            @empty
                <p>Nema dodatih vrsta placanja</p>
            @endforelse
        </table>
    </div>
    <div class="col-md-4 ml-5 float-lg-right px-lg-5">
        @yield('vrstePlacanja')
    </div>
@endsection
