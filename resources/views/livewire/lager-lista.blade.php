<div>
    <div class="row mb-4">
        <div class="col">
            <input wire:model="search" id="search" class="form-control" type="text" placeholder="Pretrazi...">
        </div>
    </div>
    <table class="table table-borderless table-responsive">
        <thead>
        <tr>
            <th class="text-light" wire:click="sortBy('PLUKod')">Sifra</th>
            <th class="text-light" wire:click="sortBy('Naziv')">Naziv</th>
            <th class="text-light" >Zadnja nabavna cena</th>
            <th class="text-light" >Zadnja prodajna cena</th>
            <th class="text-light" >Stanje</th>
        </tr>
        </thead>
        <tbody>
        @foreach($artikli as $artikal)
            <tr>
                <td class="font-weight-bold text-light" >{{$artikal->PLUKod}}</td>
                <td class="font-weight-bold text-light" >{{$artikal->Naziv}}</td>
                <td class="font-weight-bold text-light">{{$artikal->magacin->ZadnjaNabavnaCena}}</td>
                <td class="font-weight-bold text-light">{{$artikal->magacin->ZadnjaProdajnaCena}}</td>
                <td class="font-weight-bold text-light">{{$artikal->magacin->naStanju()}}</td>
                <td>
                    <button type="button" wire:click="kartica({{$artikal->PLUKod}})" class="btn btn-info">Kartica</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$artikli->links()}}
    @if($artikalKartica)
        <livewire:lager-kartica-artikla/>
    @endif
</div>
