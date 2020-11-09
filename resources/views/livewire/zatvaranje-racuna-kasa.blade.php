<div>
    <div>
        <button type="button" class="btn btn-danger" wire:click="zOpen">Zatvori zapoceti racun</button>
    </div>
    <div wire:ignore.self class="modal h-100 w-100"  id="zRacun" aria-hidden="true">
        <div class="modal-dialog modal-sm text-light" role="document" >
            <div class="modal-content" style="background-color: #8b4513">
                <div class="modal-header">
                    <h5 class="modal-title text-light font-weight-bold" id="exampleModalLabel"></h5>
                    {{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                    {{--                        <span aria-hidden="true close-btn">×</span>--}}
                    {{--                    </button>--}}
                </div>
                <div class="text-light font-weight-bold">
                    Ovo se koristi samo kad je racun zapocet!
                </div>
                <div class="modal-body">
                    <div style="display: flex;flex-direction: column">
                        <button wire:click="zGotovina" class="btn btn-success" type="button">Zatvori gotovinom</button>
                        <button wire:click="zCek" class="btn btn-success" type="button">Zatvori cekom</button>
                        <button wire:click="zKartica" class="btn btn-success" type="button">Zatvori karticom</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="close" class="btn btn-secondary close-btn" data-dismiss="modal">Zatvori</button>
                </div>
            </div>
        </div>
    </div>
</div>
