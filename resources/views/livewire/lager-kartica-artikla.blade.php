<div wire:ignore.self class="modal h-100 w-100"  id="karticaArtikla" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" >
        <div class="modal-content" style="background-color: saddlebrown">
{{--            <input type="hidden" wire:model="artikalKartica">--}}
            <div class="modal-header">
                <h5 class="modal-title text-light font-weight-bold" id="exampleModalLabel">{{$artikalKartica->Naziv}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="row mb-4">
                    <div class="col">
                        <input wire:model="searchDok" id="searchDok" class="form-control" type="date" placeholder="Pretrazi...">
                    </div>
                </div>
                <table class="table table-borderless table-responsive">
                    <thead>
                    <tr>
                        <th class="text-light" >Vrsta</th>
                        <th class="text-light" >Broj dokumenta</th>
                        <th class="text-light" >Datum dokumenta</th>
                        <th class="text-light" >Kolicina</th>
                        <th class="text-light" >Nabavna cena</th>
                        <th class="text-light">Prodajna cena</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($stavkeDokumenta as $stavka)
                        <tr>
                            <td class="font-weight-bold text-light" >{{$stavka->dokument->VrstaDok==='z' ? 'Zatvoren' : $stavka->dokument->vrstaDokumenta->Opis}}</td>
                            <td class="font-weight-bold text-light" >{{$stavka->dokument->BrDok}}</td>
                            <td class="font-weight-bold text-light">{{date_format($stavka->dokument->created_at,'d/m/Y')}}</td>
                            <td class="font-weight-bold text-light">{{($stavka->dokument->vrstaDokumenta->Sifra==='KLM' ||  $stavka->dokument->vrstaDokumenta->Sifra==='RCM')  ?  $stavka->Kolicina : '-'}}</td>
                            <td class="font-weight-bold text-light">{{$stavka->dokument->vrstaDokumenta->Sifra==='KLM' ? $stavka->NabCena : '-'}}</td>
                            <td class="font-weight-bold text-light">{{($stavka->dokument->vrstaDokumenta->Sifra==='NIV' ||  $stavka->dokument->vrstaDokumenta->Sifra==='RCM' ) ? $stavka->ProdCena : '-'}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$stavkeDokumenta->links()}}
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="close" class="btn btn-secondary close-btn" data-dismiss="modal">Zatvori</button>
            </div>
        </div>
    </div>
</div>
