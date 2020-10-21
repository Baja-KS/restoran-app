<div class="card">
{{--    <div class="card-header bg-gray">--}}
{{--        <div class="d-flex flex-column flex-sm-row d-flex justify-content-end">--}}
{{--            <livewire:komitenti-create/>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="card-body">
        <div class="row mb-4">
{{--            <div class="col form-inline">--}}
{{--                <select wire:model="perPage" class="form-control">--}}
{{--                    <option>5</option>--}}
{{--                    <option>10</option>--}}
{{--                    <option>15</option>--}}
{{--                    <option>25</option>--}}
{{--                </select>--}}
{{--            </div>--}}

            <div class="col">
                <input wire:model="search" id="search" class="form-control" type="text" placeholder="Pretrazi...">
            </div>
        </div>
        {{-- <input type="search" placeholder="Pretraga" id="search" wire:model="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-300 focus:shadow-outline-blue sm:text-sm transition duration-150 ease-in-out"> --}}
        <div class="table-responsive">
            <table class="table table-striped divide-y divide-gray-200">
                <thead>
                <th><span wire:click="sortBy('BrDok')">Broj racuna</span></th>
                <th><span wire:click="sortBy('created_at')">Datum</span></th>
                <th><span>Kupac</span></th>
                <th><span wire:click="sortBy('Ukupno1')">Vrednost</span></th>
{{--                <th><span>Uredi</span></th>--}}
                </thead>
                <tbody>
                @foreach($racuni as $racun)
                    <tr>

                        <td>{{$racun->BrDok}}</td>
                        <td>{{date_format($racun->created_at,'d/m/Y')}}</td>
                        <td>{{$racun->komitent->Naziv}}</td>
                        <td>{{$racun->Ukupno1}}</td>
                        <td width="8%">
                            {{--                        <button type="button" class="btn btn-warning" wire:click="editMesto({{$firma->FirmaID}})">Izmeni</button>--}}
                            {{-- <button type="button" class="btn btn-warning" wire:click="edit({{$komitent->KomitentID}})" data-toggle="modal" data-target="#editModal" >Izmeni</button> --}}
                            <a wire:click="print({{$racun->id}},{{$gotovinski? 'true' : 'false'}})" class="btn btn-info">
                                <i
                                    class="fa fa-print text-green-500 hover:bg-green-500 hover:text-white p-2 rounded-lg">Stampa</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col">
                {{ $racuni->links() }}
            </div>

{{--            <div class="col text-right text-muted">--}}
{{--                {{ $racuni->total() }} rezultata--}}
{{--            </div>--}}
        </div>

    </div>
</div>
