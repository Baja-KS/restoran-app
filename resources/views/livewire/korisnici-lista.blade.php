<div>
    <div class="row mb-4">
        <div class="col">
            <input wire:model="search" id="search" class="form-control" type="text" placeholder="Pretrazi...">
        </div>
    </div>
    <table class="table table-borderless table-responsive">
        <thead>
        <tr>
            <th class="text-light"  wire:click="sortBy('CompleteName')">Ime</th>
            <th class="text-light"  wire:click="sortBy('UserID')">Korisnicko Ime</th>
            <th class="text-light" wire:click="sortBy('Objekat')" >Objekat</th>
            <th class="text-light" wire:click="sortBy('Kasa')">Kasa</th>
        </tr>
        </thead>
        <tbody>
        @foreach($korisnici as $korisnik)
            <tr>
                <td class="font-weight-bold @if($korisnik->isAdmin()) text-success @else text-light @endif">{{$korisnik->CompleteName}}</td>
                <td class="font-weight-bold @if($korisnik->isAdmin()) text-success @else text-light @endif">{{$korisnik->UserID}}</td>
                <td class="font-weight-bold @if($korisnik->isAdmin()) text-success @else text-light @endif">{{$korisnik->Objekat}}</td>
                <td class="font-weight-bold @if($korisnik->isAdmin()) text-success @else text-light @endif">{{$korisnik->Kasa}}</td>
                <td>
                    <a href="{{route('editKorisnik',$korisnik->PK)}}" class="btn btn-warning">Izmeni</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$korisnici->links()}}
</div>
