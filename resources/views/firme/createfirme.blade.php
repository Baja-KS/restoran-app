@extends('firme.firme')

@section('firme')
    <div class="card-body">
        <form method="POST" action="{{ route('storeFirma') }}">
            @csrf
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="naziv" class="col-md-4 col-form-label text-md-right">{{ __('Naziv') }}</label>

                    <div class="col-md-6">
                        <input id="naziv" type="text" class="form-control @error('naziv') is-invalid @enderror" name="naziv" value="{{ old('naziv') }}" required autocomplete="naziv" autofocus>

                        @error('naziv')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="adresa" class="col-md-4 col-form-label text-md-right">{{ __('Adresa') }}</label>

                    <div class="col-md-6">
                        <input id="adresa" type="text" class="form-control @error('adresa') is-invalid @enderror" name="adresa" value="{{ old('adresa') }}" required autocomplete="adresa" autofocus>

                        @error('adresa')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pib" class="col-md-4 col-form-label text-md-right">{{ __('PIB') }}</label>

                    <div class="col-md-6">
                        <input id="pib" type="text" class="form-control @error('pib') is-invalid @enderror" name="pib" value="{{ old('pib') }}" required autocomplete="pib" autofocus>

                        @error('pib')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="maticnibroj" class="col-md-4 col-form-label text-md-right">{{ __('Maticni Broj') }}</label>

                    <div class="col-md-6">
                        <input id="maticnibroj" type="text" class="form-control @error('maticnibroj') is-invalid @enderror" name="maticnibroj" value="{{ old('maticnibroj') }}" required autocomplete="maticnibroj" autofocus>

                        @error('maticnibroj')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tekuciracun" class="col-md-4 col-form-label text-md-right">{{ __('Tekuci racun') }}</label>

                    <div class="col-md-6">
                        <input id="tekuciracun" type="text" class="form-control @error('tekuciracun') is-invalid @enderror" name="tekuciracun" value="{{ old('tekuciracun') }}" required autocomplete="tekuciracun" autofocus>

                        @error('tekuciracun')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="banka" class="col-md-4 col-form-label text-md-right">{{ __('Banka') }}</label>

                    <div class="col-md-6">
                        <input id="banka" type="text" class="form-control @error('banka') is-invalid @enderror" name="banka" value="{{ old('banka') }}" required autocomplete="banka" autofocus>

                        @error('banka')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="telefon" class="col-md-4 col-form-label text-md-right">{{ __('Telefon') }}</label>

                    <div class="col-md-6">
                        <input id="telefon" type="text" class="form-control @error('telefon') is-invalid @enderror" name="telefon" value="{{ old('telefon') }}" required autocomplete="telefon" autofocus>

                        @error('telefon')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">

                <div class="form-group row">
                    <label for="faks" class="col-md-4 col-form-label text-md-right">{{ __('Faks') }}</label>

                    <div class="col-md-6">
                        <input id="faks" type="text" class="form-control @error('faks') is-invalid @enderror" name="faks" value="{{ old('faks') }}"  autocomplete="faks" autofocus>

                        @error('faks')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="poslovnagodina" class="col-md-4 col-form-label text-md-right">{{ __('Poslovna godina') }}</label>

                    <div class="col-md-6">
                        <input id="poslovnagodina" type="text" class="form-control @error('poslovnagodina') is-invalid @enderror" name="poslovnagodina" value="{{ old('poslovnagodina') }}" autocomplete="poslovnagodina" autofocus>

                        @error('poslovnagodina')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="objekat" class="col-md-4 col-form-label text-md-right">{{ __('Objekat') }}</label>

                    <div class="col-md-6">
                        <input id="objekat" type="text" class="form-control @error('objekat') is-invalid @enderror" name="objekat" value="{{ old('objekat') }}" required autocomplete="objekat" autofocus>

                        @error('objekat')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="stampacid" class="col-form-label">Poreska Stopa</label>
                    <select id="stampacid"  class="form-control dropdown" name="stampacid">
                        <option value="">Izaberi stampac</option>
                        @foreach($stampaci as $stampac)
                            <option value="{{$stampac->StampacID}}">{{$stampac->Naziv}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="pdv" class="col-form-label">PDV</label>
                    <input id="pdv" type="checkbox" name="pdv" class="form-control form-check" value="1" checked>
                </div>
                <hr>
                <br>
                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Dodaj firmu(ogranak)') }}
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection
