<div>
    <style>
        table {
            display: block;
            overflow-y: auto;
            overflow-x: hidden;
            height: 40vh;
        }
        /*#bar {*/
        /*    display: flex;*/
        /*    flex-direction: row;*/
        /*}*/
        #napomenadiv {
            display: flex;
            flex-direction: column;
            height: 10vh;
        }
        #uk {
            display: flex;
            flex-direction: column;
        }
    </style>
    <form @if($edit) wire:submit.prevent="update({{$nivelacija->id}})" @else wire:submit.prevent="create" @endif>
        <div class="flex-lg-row">
            <span class="text-light font-weight-bold mx-4">Broj nivelacije: {{$brNivelacije}}</span>
            <span class="text-light font-weight-bold mx-4">Datum nivelacije: {{$datumNivelacije}}</span>
            <div id="uk" class="float-right">
                <label for="vrednostPDVUkupno" class="text-light">Vrednost PDV</label>
                <input id="vrednostPDVUkupno" wire:model="vrednostPDVUkupno" disabled>
                {{--        <hr>--}}
                <label for="razlikaUCeniUkupno" class="text-light">Razlika u Ceni</label>
                <input id="razlikaUCeniUkupno" disabled wire:model="razlikaUCeniUkupno">
            </div>
        </div>
        <div>
            <div class="form-group">
                <table class="table table-borderless" id="tabelakomponenti">
                    <thead>
                    <tr class="font-weight-bold text-light">
                        <th>Sifra</th>
                        <th>Naziv</th>
                        <th>JM</th>
                        <th>Kolicina</th>
                        <th>PDV %</th>
                        <th>Zadnja Prodajna Cena</th>
                        <th>Nova Prodajna Cena</th>
                        <th>Razlika u Ceni</th>
                        <th>Vrednost PDV</th>
                        @if(!$edit || !$nivelacija->IndikatorKnjizenja)<th><button type="button" wire:click="incRowCount" class="btn btn-success btn-sm" id="btnadd">+</button></th>@endif
                    </tr>
                    </thead>
                    <tbody>
{{--                    @if($edit)--}}
                        @for($i=0;$i<$rowCount;$i++)
                            <tr>
                                <td><select @if($edit && $nivelacija->IndikatorKnjizenja) disabled @endif class="form-control  dropdown" required wire:model="sifra.{{$i}}"><option  disabled class="defopcija" value="">Sifra artikla</option> @foreach($artikli as $artikal)<option value="{{$artikal->PLUKod}}" >{{$artikal->PLUKod}}</option> @endforeach </select></td>';
                                <td><select @if($edit && $nivelacija->IndikatorKnjizenja) disabled @endif  class="form-control dropdown" required wire:model="sifra.{{$i}}"><option disabled class="defopcija" value="">Naziv artikla</option> @foreach($artikli as $artikal)<option value="{{$artikal->PLUKod}}" >{{$artikal->Naziv}}</option> @endforeach </select></td>';
                                <td><input  required type="text" disabled class="jm1 form-control" wire:model="jm.{{$i}}" ></td>
                                <td><input required type="number" disabled  class="form-control kolicina1" min="0" step="0.01" wire:model="kolicina.{{$i}}"></td>
                                <td><input   type="number" disabled class="form-control pdv1" min="0" step="0.01" wire:model="pdv.{{$i}}" ></td>
                                <td><input  required type="number"  disabled   class="form-control nc1" min="0" step="0.01" wire:model="zadnjaProdajnaCena.{{$i}}"></td>
                                <td><input required type="number" @if($edit && $nivelacija->IndikatorKnjizenja) disabled @endif  class="form-control rabat1" min="0" step="0.01" wire:model="novaProdajnaCena.{{$i}}"></td>
                                <td><input  type="number" disabled class="form-control ncsr1" min="0" step="0.01" wire:model="razlikaUCeni.{{$i}}"></td>
                                <td><input  type="number" disabled class="form-control ncp1" min="0" step="0.01" wire:model="vrednostPDV.{{$i}}"></td>
                                @if($i>0)
                                    <td><button type="button" wire:click="decRowCount({{$i}})" class="btn btn-danger btnremove1 btn-sm">-</button></td>
                                @endif
                            </tr>
                        @endfor
{{--                    @endif--}}
                    </tbody>
                </table>
                <div id="napomenadiv" class="col-2">
                    <label for="napomena" class="">Napomena</label>
                    <textarea id="napomena" @if($edit && $nivelacija->IndikatorKnjizenja) disabled @endif wire:model="napomena"></textarea>
                </div>
                <div class="float-right">
                    <a href="{{route('listaNivelacije')}}" class="btn btn-warning">Nazad</a>
                    @if(!$edit || !$nivelacija->IndikatorKnjizenja)
                        <button type="submit" name="sub" class="btn btn-success">@if($edit) Sacuvaj izmenu @else Nova Nivelacija @endif</button>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
