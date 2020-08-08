@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <a href="{{route('home')}}" class="btn btn-success">Nazad</a>
    <div class="col-md-4 justify-content-lg-start px-lg-5">
        <h2>Stampaci</h2>
        <hr>
        <table class="table table-borderless">
            @if($stampaci->count()>0)
                <thead>
                <tr>
                    <th>ID Stampaca</th>
                    <th>Naziv</th>
                </tr>
                </thead>
            @endif
            @forelse($stampaci as $stampac)
                <tr>
                    <td><h4>{{$stampac->StampacID}}</h4></td>
                    <td><h4>{{$stampac->Naziv}}</h4></td>
                    <td><h4>{{$stampac->AkcijaStampaca}}</h4></td>
                    <td><a href="{{route('editStampac',$stampac->StampacID)}}" class="btn btn-warning">Edit</a></td>
                    <td><form action="{{route('destroyStampac',$stampac->StampacID)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form></td>
                </tr>
            @empty
                <p>Nema dodatih stampaca</p>
            @endforelse
        </table>
    </div>
    <div class="col-md-4 ml-5 float-lg-right px-lg-5">
        @yield('stampaci')
    </div>
@endsection
