@extends('layouts.welcome')

@section('content')
    <a href="{{route('home')}}" class="btn btn-success">Nazad</a>
    <div class="col-md-4 justify-content-lg-start px-lg-5">
        <h2>Organizacione jedinice</h2>
        <hr>
        <table class="table table-borderless">
            @if($organizacionejedinice->count()>0)
                <thead>
                <tr>
                    <th>Sifra</th>
                    <th>Naziv</th>
                </tr>
                </thead>
            @endif
            @forelse($organizacionejedinice as $organizacionajedinica)
                <tr>
                    <td><h4>{{$organizacionajedinica->SifOj}}</h4></td>
                    <td><a href="{{route('showOrganizacionajedinica',$organizacionajedinica->SifOj)}}"><h4>{{$organizacionajedinica->Naziv}}</h4></a></td>
                    <td><a href="{{route('editOrganizacionajedinica',$organizacionajedinica->SifOj)}}" class="btn btn-warning">Edit</a></td>
                    <td><form action="{{route('destroyOrganizacionajedinica',$organizacionajedinica->SifOj)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form></td>
                </tr>
            @empty
                <p>Nema dodatih organizacionih jedinica</p>
            @endforelse
        </table>
    </div>
    <div class="col-md-4 ml-5 float-lg-right px-lg-5">
        @yield('orgjed')
    </div>
@endsection
