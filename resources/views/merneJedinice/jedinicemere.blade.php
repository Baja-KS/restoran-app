@extends('layouts.welcome')

@section('content')
    <a href="{{route('home')}}" class="btn btn-success">Nazad</a>
    <div class="col-md-4 justify-content-lg-start px-lg-5">
        <h2>Jedinice mere</h2>
        <hr>
        <table>
            @forelse($jedinice as $jedinica)
                <tr>
                    <td><h4>{{$jedinica->Naziv}}</h4></td>
                    <td><a href="{{route('editJedinicamere',$jedinica->JMID)}}" class="btn btn-warning">Edit</a></td>
                    <td><form action="{{route('destroyJedinicamere',$jedinica->JMID)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form></td>
                </tr>
            @empty
                <p>Nema dodatih jedinica mere</p>
            @endforelse
        </table>
    </div>
    <div class="col-md-4 ml-5 float-lg-right px-lg-5">
        @yield('jmform')
    </div>
@endsection
