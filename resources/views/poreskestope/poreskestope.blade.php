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
        @yield('psform')
    </div>
@endsection
