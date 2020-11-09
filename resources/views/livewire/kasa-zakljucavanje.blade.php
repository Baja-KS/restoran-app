<div style="display: flex;flex-direction: column;flex-wrap: wrap" >
    @for($i=1;$i<=config('app.brojStolova');$i++)
        @if($konobarZaSto[$i] ?? 0)
            <div style="display: inline-flex" class="my-2">
                <label class="text-light mx-4"  for="konobar">Sto {{$i}}:</label>
                <select id="konobar" wire:model="konobarZaSto.{{$i}}">
                    @foreach($radnici as $radnik)
                        <option value="{{$radnik->PK}}">{{$radnik->CompleteName}}</option>
                    @endforeach
                </select>
            </div>
        @endif
    @endfor
    <div>
        <button type="button" wire:click="potvrdiIzmene" class="btn btn-success">Sacuvaj izmene</button>
    </div>
        <div wire:ignore.self class="modal h-100 w-100"  id="potvrdiIzmene" aria-hidden="true">
            <div class="modal-dialog modal-sm text-light" role="document" >
                <div class="modal-content" style="background-color: #8b4513">
                    <div class="modal-body">
                        <div>
                            Da li sigurno zelite da sacuvate izmene?
                        </div>
                        <div style="display: flex;flex-direction: row">
                            <button wire:click="sacuvajIzmene" class="btn btn-success" type="button">Da</button>
                            <button wire:click="close" class="btn btn-success" type="button">Ne</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
