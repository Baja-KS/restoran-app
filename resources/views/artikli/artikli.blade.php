@extends('layouts.welcome')

@section('content')
    <div class="col-md-6 justify-content-lg-start px-lg-5">
        <h2>Artikli</h2>
        <hr>
        <table class="table table-borderless">
            @if($artikli->count()>0)
            <thead>
            <tr>
                <th>PLUKod</th>
                <th>Naziv</th>
                <th>Kategorija</th>
                <th>Jedinica Mere</th>
                <th>Poreska Stopa</th>
                <th>Na Stanju</th>
            </tr>
            </thead>
            @endif
            @forelse($artikli as $artikal)
                <tr>
                    <td><h4>{{$artikal->PLUKod}}</h4></td>
                    <td><a href="{{route('showArtikal',$artikal->PLUKod)}}"><h4>{{$artikal->Naziv}}</h4></a></td>
                    <td><h4>{{$artikal->podkategorija->Naziv}}</h4></td>
                    @if(!$artikal->Normativ)
                    <td><h4>{{$artikal->jedinicamere->Naziv}}</h4></td>
                    @else
                        <td><h4>Normativ</h4></td>
                    @endif
                    <td><h4>{{$artikal->poreskastopa->Vrednost}}%</h4></td>
                    @if(!$artikal->Normativ)
                    <td><h4>{{$artikal->magacin->naStanju()}}</h4></td>
                    @else
                    <td><h4>Normativ</h4></td>
                    @endif
                    <td><a href="{{route('editArtikal',$artikal->PLUKod)}}" class="btn btn-warning">Edit</a></td>
                    <td><form action="{{route('destroyArtikal',$artikal->PLUKod)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form></td>
                </tr>
            @empty
                <p>Nema nijednog artikla</p>
            @endforelse
        </table>
        {{$artikli->links()}}
    <a href="{{route('createArtikal')}}" class="btn btn-info">Dodaj artikal</a>
    <a href="{{route('home')}}" class="btn btn-warning">Nazad</a>
    </div>

@endsection
