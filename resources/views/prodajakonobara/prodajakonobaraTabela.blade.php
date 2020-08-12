@extends('prodajakonobara.prodajakonobara')

@section('tabela')
    <h2 class="text-light">Konobar:{{auth()->user()->CompleteName}}</h2>
    <table class="table table-light table-borderless table-responsive">
        <thead>
            <tr>
                <th></th>
                @if($svi)
                    <th>Konobar</th>
                @endif
                <th>Datum</th>
                    <th>Vreme</th>
                <th>Kupac</th>
                <th>Br.dokumenta</th>
                <th>Gotovina</th>
                <th>Cek</th>
                <th>Kartica</th>
                <th>Prodato/Zatvoreno</th>
                <th>Sto</th>
                <th>Zarada</th>
            </tr>
        </thead>
        <tbody>
            @foreach($racuni as $racun)
                <tr>
                    <td><input type="hidden" id="r{{$racun->id}}" value="{{$racun->id}}"></td>
                    @if($svi)
                        <td>{{$racun->radnik->CompleteName}}</td>
                    @endif
                    <td>{{$racun->created_at->format('d/m/Y')}}</td>
                        <td>{{$racun->created_at->format("H:i")}}</td>
                    <td>{{$racun->komitent->Naziv ?? '/'}}</td>
                        <td>{{$racun->BrDok}}</td>
                    <td>{{$racun->Gotovina}}</td>
                    <td>{{$racun->Cek}}</td>
                    <td>{{$racun->Kartica}}</td>
                    <td>{{$racun->VrstaDok}}</td>
                    <td>{{$racun->BrojStola}}</td>
                    <td>{{$racun->profit()}}</td>
                        <td><a class="btn btn-success" href="{{route('detaljiProdaja',$racun->id)}}">Detalji racuna</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>{{$racuni->links()}}</div>
@endsection
