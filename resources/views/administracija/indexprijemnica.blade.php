@extends('administracija.base')

@section('tab-content')
<div>
    <table id="listaPrijemnica" class="table table-borderless ">
        <thead>
            <tr>
                <th class="text-light" scope="col">Br. prijemnice</th>
                <th class="text-light" scope="col">Broj dokumenta</th>
                <th class="text-light" scope="col">Dobavljac</th>
                <th class="text-light" scope="col">Datum dokumenta</th>
                <th class="text-light" scope="col">Proknjizena</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prijemnice as $prijemnica)
                <tr>
                    <td class="font-weight-bold text-light">{{$prijemnica->BrDok}}</td>
                    <td class="font-weight-bold text-light">{{$prijemnica->BrFiskal}}</td>
                    <td class="font-weight-bold text-light">{{$prijemnica->komitent->Naziv ?? "N/A"}}</td>
                    <td class="font-weight-bold text-light">{{\Carbon\Carbon::parse($prijemnica->created_at)->format("d/m/Y")}}</td>
                    <td class="font-weight-bold text-light">{{$prijemnica->IndikatorKnjizenja ? "Da" : "Ne"}}</td>
                    <td>
                        <a href="{{route('editPrijemnica',$prijemnica->id)}}" class="btn btn-warning">Izmeni</a>
                    </td>
                    @if(!$prijemnica->IndikatorKnjizenja)
                    <td>
                        <form action="{{route('destroyPrijemnica',$prijemnica->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
{{--                            <input type="hidden" name="iddel" value="{{$prijemnica->id}}">--}}
                            <button type="submit" class="btn btn-danger">Izbrisi</button>
                        </form>
                    </td>
                    @endif
                    <td>
                        <a href="{{route('pregledPrijemnica',$prijemnica->id)}}" class="btn btn-info">Stampanje</a>
                    </td>
                    @if(!$prijemnica->IndikatorKnjizenja)
                    <td>
                        <form action="{{route('proknjiziPrijemnica',$prijemnica->id)}}" method="POST">
                            @csrf
                            @method('PATCH')
{{--                            <input type="hidden" name="idkn" value="{{$prijemnica->id}}">--}}
                            <button type="submit" class="btn btn-success">Proknjizi</button>
                        </form>
                    </td>
                    @endif
                    @if($prijemnica->IndikatorKnjizenja)
                    <td>
                        <a href="" class="btn btn-danger">Rasknjizavanje</a>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    {{$prijemnice->links()}}
    <div class="float-right">
        <a href="{{route('createPrijemnica')}}" class="btn btn-success">Nova Prijemnica</a>
    </div>
</div>
{{--    <script>--}}
{{--        $(document).ready(function (){--}}
{{--            $("#listaPrijemnica").DataTable({--}}
{{--                processing:true,--}}
{{--                serverSide:true,--}}
{{--                ajax:"{{route('tablePrijemnica')}}",--}}
{{--                columns: [--}}
{{--                    {data:'BrDok',name:"Br.prijemnice"},--}}
{{--                    {data:'BrFiskal',name:"Broj dokumenta"},--}}
{{--                    {data:'created_at',name:'Datum dokumenta'}--}}
{{--                ]--}}
{{--            })--}}
{{--        })--}}
{{--    </script>--}}
@endsection
