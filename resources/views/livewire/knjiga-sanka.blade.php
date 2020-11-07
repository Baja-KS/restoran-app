<div>
    <div wire:ignore.self class="modal h-100 w-100"  id="knjigaSanka" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" >
            <div class="modal-content" style="background-color: saddlebrown">
                <div class="modal-header">
                    <h5 class="modal-title text-light font-weight-bold mx-4" id="exampleModalLabel">Knjiga sanka za dan:@if($search) {{$search}} @endif</h5>
                    <button wire:click="preview" type="button" class="btn btn-primary mx-4">Stampa DPU</button>
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true close-btn">×</span>--}}
{{--                    </button>--}}
                </div>
                <div class="modal-body" >
                    <div class="row mb-4">
                        <div class="col">
                            <input wire:model="search" id="search" class="form-control" type="date" placeholder="Datum">
                            <select wire:model="pice">
                                <option value="0">Hrana</option>
                                <option value="1">Pice</option>
                            </select>
                        </div>
                    </div>
                    <table class="table table-borderless table-responsive">
                        <thead>
                        <tr>
                            <th class="text-light" >Naziv Artikla</th>
                            <th class="text-light" >Stopa PDV</th>
                            <th class="text-light" >JM</th>
                            <th class="text-light" >Nabavka</th>
                            <th class="text-light" >Prodaja</th>
                            <th class="text-light">Prodajna cena</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($artikliDPU as $artikal)
                                <tr>
                                    <td class="font-weight-bold text-light" >{{$artikal->Naziv}}</td>
                                    <td class="font-weight-bold text-light" >{{$artikal->poreskastopa->Vrednost}}%</td>
                                    <td class="font-weight-bold text-light">{{$artikal->jedinicamere->Naziv}}</td>
                                    <td class="font-weight-bold text-light">{{$nabavkaZaDan[$artikal->PLUKod] ?? 0}}</td>
                                    <td class="font-weight-bold text-light">{{$prodajaZaDan[$artikal->PLUKod] ?? 0}}</td>
                                    <td class="font-weight-bold text-light">{{$artikal->magacin->ZadnjaProdajnaCena}}</td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($artikliDPU)
                        {{$artikliDPU->links()}}
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="closeKS" class="btn btn-secondary close-btn" data-dismiss="modal">Zatvori</button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal h-100 w-100" id="dpuPreview" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pregled DPU liste</h5>
{{--                    <button type="button" wire:click.prevent="closeDPU" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true close-btn">×</span>--}}
{{--                    </button>--}}
                </div>
                <div class="modal-body h-100" id="previewModalBodyDPU">

                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="closeDPU" class="btn btn-secondary close-btn" data-dismiss="modal">Zatvori</button>
                    <button type="button" wire:click.prevent="printDPU" class="btn btn-primary close-modal">Stampaj</button>
                </div>
            </div>
        </div>
    </div>
</div>
