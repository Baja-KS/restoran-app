<div>
    <div class="row mb-4">
        <div class="col">
            <input wire:model="search" id="search" class="form-control" type="text" placeholder="Pretrazi...">
        </div>
    </div>
    <table class="table table-borderless table-responsive">
        <thead>
        <tr>
            <th class="text-light"  wire:click="sortBy('BrDok')">Br. nivelacije</th>
            <th class="text-light"  wire:click="sortBy('created_at')">Datum dokumenta</th>
            <th class="text-light" >Razlika u ceni</th>
            <th class="text-light" >Vrednost PDV</th>
            <th class="text-light" >Proknjizena</th>
        </tr>
        </thead>
        <tbody>
        @foreach($nivelacije as $nivelacija)
            <tr>
                <td class="font-weight-bold text-light">{{$nivelacija->BrDok}}</td>
                <td class="font-weight-bold text-light">{{\Carbon\Carbon::parse($nivelacija->created_at)->format("d/m/Y")}}</td>
                <td class="font-weight-bold text-light">{{round($nivelacija->razlikaUCeni(),2)}}</td>
                <td class="font-weight-bold text-light">{{round($nivelacija->vrednostPDVpoRazlici(),2)}}</td>
                <td class="font-weight-bold text-light">{{$nivelacija->IndikatorKnjizenja ? "Da" : "Ne"}}</td>
                <td>
                    <a href="{{route('izmeniNivelaciju',$nivelacija->id)}}" class="btn btn-warning">Izmeni</a>
                </td>
                @if(!$nivelacija->IndikatorKnjizenja)
                    <td>
                        <button type="button" wire:click="delete({{$nivelacija->id}})" class="btn btn-danger">Izbrisi</button>
                    </td>
                @endif
                <td>
                    <button type="button" wire:click="print({{$nivelacija->id}})" class="btn btn-info">Stampanje</button>
                </td>
                @if(!$nivelacija->IndikatorKnjizenja)
                    <td>
                        <button type="button" wire:click="knjizenje({{$nivelacija->id}})" class="btn btn-danger">Proknjizi</button>
                    </td>
                @endif
                @if($nivelacija->IndikatorKnjizenja)
                    <td>
                        <button type="button" wire:click="rasknjizavanje({{$nivelacija->id}})" class="btn btn-danger">Rasknjizi</button>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$nivelacije->links()}}
    <div class="float-right">
        <a href="{{route('dodajNivelaciju')}}" class="btn btn-success">Nova Nivelacija</a>
    </div>
</div>
