@extends('layouts.welcome')

@section('content')
    <div class="card-body">
        <a href="{{route('indexJedinicamere')}}" class="btn btn-success">Nazad</a>
        <form method="POST" action="{{ route('updateJedinicamere',$jedinica->JMID) }}">
            @csrf
            @method('PATCH')
            <div class="form-group row">
                <label for="ujm" class="col-md-4 col-form-label text-md-right">{{ __('Novo ime merne jedinice') }}</label>

                <div class="col-md-6">
                    <input id="ujm" type="text" class="form-control @error('ujm') is-invalid @enderror" name="ujm" value="{{ $jedinica->Naziv }}" required autocomplete="ujm" autofocus>

                    @error('ujm')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Azuriraj jedinicu') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
