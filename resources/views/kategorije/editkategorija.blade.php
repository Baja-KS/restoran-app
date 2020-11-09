@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <div class="card-body">
        <a href="{{route('indexKategorija')}}" class="btn btn-success">Nazad</a>
        <form method="POST" action="{{ route('updateKategorija',$kategorija->SifKat) }}">
            @csrf
            @method('PATCH')
            <div class="container-fluid" style="background-color: saddlebrown">
                <div class="form-group row">
                    <label for="ukat" class="col-md-4 col-form-label text-md-right">{{ __('Novo ime grupe') }}</label>

                    <div class="col-md-6">
                        <input id="ukat" type="text" class="form-control @error('ukat') is-invalid @enderror" name="ukat" value="{{ $kategorija->Naziv }}" required autocomplete="ukat" autofocus>

                        @error('ukat')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Azuriraj grupu') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
