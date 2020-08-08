@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <div class="col-md-6 container">
        <h2>Artikli</h2>
        <hr>
        <table class="table table-borderless  table-danger" >
            @if($artikli->count()>0)
            <thead>
            <tr>
                <th>PLUKod</th>
                <th>Naziv</th>
                <th>Kategorija</th>
                <th>Grupa</th>
                <th>Jedinica Mere</th>
                <th>Poreska Stopa</th>
                <th>Na Stanju</th>
                <th>Normativ</th>
                <th>Aktivan</th>
            </tr>
            </thead>
            @endif
            @forelse($artikli as $artikal)
                <tr>
                    <td><h4>{{$artikal->PLUKod}}</h4></td>
                    <td><a href="{{route('showArtikal',$artikal->PLUKod)}}"><h4>{{$artikal->Naziv}}</h4></a></td>
                    <td><h4>{{$artikal->podkategorija->Naziv}}</h4></td>
                    <td><h4>{{$artikal->podkategorija->glavnaKategorija->Naziv}}</h4></td>
                    <td><h4>{{$artikal->jedinicamere->Naziv}}</h4></td>
                    <td><h4>{{$artikal->poreskastopa->Vrednost}}%</h4></td>
                    <td><h4>{{$artikal->magacin->naStanju()}}</h4></td>
                    <td><h4>{{$artikal->Normativ? "Da" : "Ne"}}</h4></td>
                    <td><h4>{{$artikal->Aktivan? "Da" : "Ne"}}</h4></td>
                    <td><a href="{{route('editArtikal',$artikal->PLUKod)}}" class="btn btn-warning">Edit</a></td>
                    {{--<td><form action="{{route('destroyArtikal',$artikal->PLUKod)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form></td>--}}
                </tr>
            @empty
                <p>Nema nijednog artikla</p>
            @endforelse
        </table>
        <div class="row">
            <div class="col-md-6">{{$artikli->links()}}</div>
            <div class="col-md-6">
                <a href="{{route('createArtikal')}}" class="btn btn-info">Dodaj artikal</a>
                <a href="{{route('home')}}" class="btn btn-warning">Nazad</a>
            </div>
        </div>
    </div>

@endsection
