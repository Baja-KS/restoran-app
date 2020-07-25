@extends('orgjedinice.orgjedinice')

@section('orgjed')
    <div class="card-body">
        <form method="POST" action="{{ route('updateOrganizacionajedinica',$organizacionajedinica->SifOj) }}">
            @csrf
            @method('PATCH')
            <div class="form-group row">
                <label for="vrsta" class="col-md-4 col-form-label text-md-right">{{ __('Vrsta) }}</label>

                <div class="col-md-6">
                    <input id="vrsta" type="text" class="form-control @error('vrsta') is-invalid @enderror" name="vrsta" value="{{ $organizacionajedinica->Vrsta }}" required autocomplete="vrsta" autofocus>

                    @error('vrsta')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="naziv" class="col-md-4 col-form-label text-md-right">{{ __('Naziv') }}</label>

                <div class="col-md-6">
                    <input id="naziv" type="text" class="form-control @error('naziv') is-invalid @enderror" name="naziv" value="{{ $organizacionajedinica->Naziv }}" required autocomplete="naziv" autofocus>

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
                    <input id="adresa" type="text" class="form-control @error('adresa') is-invalid @enderror" name="adresa" value="{{ $organizacionajedinica->Adresa }}"autocomplete="adresa" autofocus>

                    @error('adresa')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="postbr" class="col-md-4 col-form-label text-md-right">{{ __('Postanski Broj') }}</label>

                <div class="col-md-6">
                    <input id="postbr" type="text" class="form-control @error('postbr') is-invalid @enderror" name="postbr" value="{{ $organizacionajedinica->PostBr }}" autocomplete="postbr" autofocus>

                    @error('postbr')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="mesto" class="col-md-4 col-form-label text-md-right">{{ __('Mesto') }}</label>

                <div class="col-md-6">
                    <input id="mesto" type="text" class="form-control @error('mesto') is-invalid @enderror" name="mesto" value="{{ $organizacionajedinica->Mesto }}" autocomplete="mesto" autofocus>

                    @error('mesto')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="telefon" class="col-md-4 col-form-label text-md-right">{{ __('Telefon') }}</label>

                <div class="col-md-6">
                    <input id="telefon" type="text" class="form-control @error('telefon') is-invalid @enderror" name="telefon" value="{{ $organizacionajedinica->Telefon }}" autocomplete="telefon" autofocus>

                    @error('telefon')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="odglice" class="col-md-4 col-form-label text-md-right">{{ __('Odgovorno Lice') }}</label>

                <div class="col-md-6">
                    <input id="odglice" type="text" class="form-control @error('odglice') is-invalid @enderror" name="odglice" value="{{ $organizacionajedinica->OdgLice }}" autocomplete="odglice" autofocus>

                    @error('odglice')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Izmeni organizacionu jedinicu') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
