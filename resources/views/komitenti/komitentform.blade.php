@extends('administracija.base')

@section('tab-content')
    <div class="flex">
        <form action="{{$edit ? route('updateKomitent',$komitent->Sifra) : route('storeKomitent')}}" method="POST">
            @csrf
            @if($edit)
                @method('PATCH')
            @endif
            <h2>@if($edit) Azuriraj @else Dodaj novog @endif komitenta</h2>
            <hr>
            <div class="col-md-2">
                <div class="form-group">
                    <div>
                        <label for="naziv" class="col-form-label">Naziv komitenta*</label>
                        <input id="naziv" type="text" class="form-control @error('naziv') is-invalid @enderror" name="naziv" value="{{$komitent->Naziv ?? "" }}" required autocomplete="naziv" autofocus>
                    </div>
                    <div>
                        <label for="adresa" class="col-form-label">Adresa*</label>
                        <input id="adresa" type="text" class="form-control @error('adresa') is-invalid @enderror" name="adresa" value="{{ $komitent->Adresa ?? ""}}" required autocomplete="adresa" autofocus>
                    </div>
                    <div>
                        <label for="pib" class="col-form-label">PIB*</label>
                        <input id="pib" type="text" class="form-control @error('pib') is-invalid @enderror" name="pib" value="{{ $komitent->PIB ?? ""}}" required autocomplete="pib" autofocus>
                    </div>
                    <div>
                        <label for="postbr" class="col-form-label">Postanski Broj</label>
                        <input id="postbr" type="text" class="form-control @error('postbr') is-invalid @enderror" name="postbr" value="{{ $komitent->PostBr ?? ""}}">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div>
                        <div>
                            <label for="mesto" class="col-form-label">Mesto</label>
                            <input id="mesto" type="text" class="form-control @error('mesto') is-invalid @enderror" name="mesto" value="{{ $komitent->Mesto ?? ""}}">
                        </div>
                        <div>
                            <label for="telefon" class="col-form-label">Telefon</label>
                            <input id="telefon" type="text" class="form-control @error('telefon') is-invalid @enderror" name="telefon" value="{{ $komitent->Telefon ?? ""}}">
                        </div>
                        <div>
                            <label for="odglice" class="col-form-label">Odgovorno Lice</label>
                            <input id="odglice" type="text" class="form-control @error('odglice') is-invalid @enderror" name="odglice" value="{{ $komitent->OdgLice ?? ""}}">
                        </div>
                        <div>
                            <label for="zr" class="col-form-label">Ziroracun</label>
                            <input id="zr" type="text" class="form-control @error('zr') is-invalid @enderror" name="zr" value="{{ $komitent->ZR ?? ""}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div>
                        <label for="matbr" class="col-form-label">Maticni Broj</label>
                        <input id="matbr" type="text" class="form-control @error('matbr') is-invalid @enderror" name="matbr" value="{{ $komitent->MatBr ?? ""}}">
                    </div>
                    <div>
                        <label for="vrkomitenta" class="col-form-label">Vrednost komitenta</label>
                        <input id="vrkomitenta" type="number" class="form-control @error('vrkomitenta') is-invalid @enderror" name="vrkomitenta" value="{{ $komitent->VrKomitenta ?? "" }}">
                    </div>
                    <div>
                        <label for="regbr" class="col-form-label">Registarski broj</label>
                        <input id="regbr" type="text" class="form-control @error('regbr') is-invalid @enderror" name="regbr" value="{{ $komitent->RegBr ?? ""}}">
                    </div>
                    <div>
                        <label for="napomena" class="col-form-label">Napomena</label>
                        <input id="napomena" type="text" class="form-control @error('napomena') is-invalid @enderror" name="napomena" value="{{ $komitent->Napomena ?? ""}}">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div>
                        <div>
                            <label for="web" class="col-form-label">Web</label>
                            <input id="web" type="text" class="form-control @error('web') is-invalid @enderror" name="web" value="{{ $komitent->Web ?? ""}}">
                        </div>
                        <div>
                            <label for="e-mail" class=" col-form-label">E-mail</label>
                            <input id="e-mail" type="email" class="form-control @error('e-mail') is-invalid @enderror" name="e-mail" value="{{ $komitent['E-mail'] ?? ""}}">
                        </div>
                        <div>
                            <label for="prenetostanje" class="col-form-label">Preneto stanje</label>
                            <input id="prenetostanje" type="number" class="form-control @error('prenetostanje') is-invalid @enderror" name="prenetostanje" value="{{ $komitent->PrenetoStanje ?? ""}}">
                        </div>
                        <div>
                            <label for="popust" class=" col-form-label">Popust</label>
                            <input id="popust" type="number" class="form-control @error('popust') is-invalid @enderror" name="popust" value="{{ $komitent->Popust ?? ""}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div>
                        <label for="pdv" class="col-form-label">PDV</label>
                        <input id="pdv" type="checkbox" name="pdv" class="form-control form-check" value="true" @if($edit && $komitent->PDV) checked @endif>
                    </div>
                    <div>
                        <label for="dobavljac" class="col-form-label">Dobavljac</label>
                        <input id="dobavljac" type="checkbox" name="dobavljac" class="form-control form-check " value="true" @if($edit && $komitent->Dobavljac) checked @endif>
                        <label for="kupac" class=" col-form-label">Kupac</label>
                        <input id="kupac" type="checkbox" name="kupac" class="form-control form-check" value="true" @if($edit && $komitent->Kupac) checked @endif>
                    </div>
                    <div>
                        <label for="inostrani" class=" col-form-label">Inostrani</label>
                        <input id="inostrani" type="checkbox" name="inostrani" class="form-control form-check" value="true" @if($edit && $komitent->Inostrani) checked @endif>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div id="drzavaWrapper" style="display: none">
                        <label for="drzava" class="col-form-label">Drzava</label>
                        <input id="drzava" type="text" name="drzava" class="form-control @error('drzava') is-invalid @enderror" @if($edit && $komitent->Inostrani) value="{{$komitent->Drzava}}" @endif>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success">@if($edit) Azuriraj @else Dodaj @endif komitenta</button>
            <a href="{{route('indexKomitent')}}" class="btn btn-info">Nazad</a>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            let inostrani = $("#inostrani");
            let drzavaWrapper = $("#drzavaWrapper");
            //zbog refresha ovo mora dva puta
            if (inostrani.is(':checked'))
                drzavaWrapper.show();
            else
                drzavaWrapper.hide();
            inostrani.change(function () {
                $("#drzava").val("")
                if ($(this).is(':checked'))
                    drzavaWrapper.show();
                else
                    drzavaWrapper.hide();
            })
        });
    </script>
@endsection
