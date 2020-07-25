@extends('vrsteplacanja.vrsteplacanja')

@section('vrstePlacanja')
    <div class="card-body">
        <form method="POST" action="{{ route('updateVrstaplacanja',$vrstaplacanja->VrstaPlacanja) }}">
            @csrf
            @method('PATCH')
            <div class="form-group row">
                <label for="naziv" class="col-md-4 col-form-label text-md-right">{{ __('Naziv') }}</label>

                <div class="col-md-6">
                    <input id="naziv" type="text" class="form-control @error('naziv') is-invalid @enderror" name="naziv" value="{{ $vrstaplacanja->Naziv }}" required autocomplete="sjm" autofocus>

                    @error('naziv')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Izmeni vrstu placanja') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
