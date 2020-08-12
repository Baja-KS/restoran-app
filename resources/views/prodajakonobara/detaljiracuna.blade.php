@extends('prodajakonobara.prodajakonobara')

@section('tabela')
    <h2 class="text-light">Konobar:{{auth()->user()->CompleteName}}</h2>
    <table class="table table-light table-borderless table-responsive">
        <thead>
        <tr>
            <th></th>
            <th>Konobar</th>
            <th>Artikal</th>
            <th>Kolicina</th>
            <th>Bez Popusta</th>
            <th>Sa Popustom</th>
            <th>Popust</th>
            <th>Profit</th>
        </tr>
        </thead>
        <tbody>
        @foreach($stavke as $stavka)
            <tr>
                <td><input type="hidden" id="r{{$stavka->id}}" value="{{$stavka->id}}"></td>
                <td>{{$racun->radnik->CompleteName}}</td>
                <td>{{$stavka->artikal->Naziv}}</td>
                <td>{{$stavka->Kolicina}}</td>
                <td>{{$stavka->artikal->magacin->ZadnjaProdajnaCena}}</td>
                <td>{{$stavka->ProdCena}}</td>
                <td>{{$stavka->popust()}}</td>
                <td>{{$stavka->profit()}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>{{$stavke->links()}}</div>
    <a href="{{url()->previous()}}" class="btn btn-warning">Nazad</a>
@endsection
