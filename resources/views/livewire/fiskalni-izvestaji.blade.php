<div>
    <div wire:ignore.self class="modal h-100 w-100"  id="fiskalniIzvestaji" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" >
            <div class="modal-content" style="background-color: #8b4513">
                <div class="modal-header">
                    <h5 class="modal-title text-light font-weight-bold" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="flex flex-row">
                        <div class="w-50 float-left" style="display: flex;flex-direction: column">
                            <button wire:click="openKnjigaSanka" class="btn btn-success" type="button">Knjiga Sanka</button>
                            <button wire:click="openPeriodicni" class="btn btn-success" type="button">Periodicni izvestaj</button>
                        </div>
                        <div class="w-50 float-right" style="display: flex;flex-direction: column">
                            <button wire:click="zatvoriDan" class="btn btn-success" type="button">Zatvaranje dana</button>
                            <button wire:click="prodatiArtikli" class="btn btn-success" type="button">1.Prodati artikli</button>
                            <button wire:click="presekStanja" class="btn btn-success" type="button">2.Presek stanja</button>
                            <button wire:click="dnevniIzvestaj" class="btn btn-success" type="button">3.Dnevni izvestaj</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="close" class="btn btn-secondary close-btn" data-dismiss="modal">Zatvori</button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal h-100 w-100"  id="dnevniIzvestaj" aria-hidden="true">
        <div class="modal-dialog modal-sm text-light" role="document" >
            <div class="modal-content" style="background-color: #8b4513">
                <div class="modal-header">
                    <h5 class="modal-title text-light font-weight-bold" id="exampleModalLabel"></h5>
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true close-btn">×</span>--}}
{{--                    </button>--}}
                </div>
                <div class="modal-body">
                    <div>
                        Da li sigurno zelite dnevni izvestaj?
                    </div>
                    <div style="display: flex;flex-direction: row">
                        <button wire:click="confirmDnevni" class="btn btn-success" type="button">Da</button>
                        <button wire:click="cancelDnevni" class="btn btn-success" type="button">Ne</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="closeDnevni" class="btn btn-secondary close-btn" data-dismiss="modal">Zatvori</button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal h-100 w-100"  id="periodicniIzvestaj" aria-hidden="true">
        <div class="modal-dialog modal-sm text-light" role="document" >
            <div class="modal-content" style="background-color: #8b4513">
                <div class="modal-header">
                    <h5 class="modal-title text-light font-weight-bold" id="exampleModalLabel">Periodicni izvestaj</h5>
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true close-btn">×</span>--}}
{{--                    </button>--}}
                </div>
                <div class="modal-body">
                    <div>
                        <input wire:model="od" id="od" class="form-control" type="date" placeholder="Pretrazi...">
                        <input wire:model="do" id="do" class="form-control" type="date" placeholder="Pretrazi...">
                    </div>
                    <div style="display: flex;flex-direction: row">
                        <button wire:click="periodicniIzvestaj" class="btn btn-success" type="button">Stampaj</button>
                        <button wire:click="closePeriodicni" class="btn btn-success" type="button">Nazad</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="closePeriodicni" class="btn btn-secondary close-btn" data-dismiss="modal">Zatvori</button>
                </div>
            </div>
        </div>
    </div>
</div>
