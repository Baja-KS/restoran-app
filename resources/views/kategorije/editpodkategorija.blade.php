@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <div class="card-body">
        <a href="{{route('indexPodkategorija',$podkategorija->glavnaKategorija->SifKat)}}" class="btn btn-success">Nazad</a>
        <form method="POST" action="{{ route('updatePodkategorija',$podkategorija->SifKat)}}">
            @csrf
            @method('PATCH')
            <div class="form-group row">
                <label for="upod" class="col-md-4 col-form-label text-md-right">{{ __('Novo ime kategorije') }}</label>

                <div class="col-md-6">
                    <input id="upod" type="text" class="form-control @error('upod') is-invalid @enderror" name="upod" value="{{ $podkategorija->Naziv }}" required autocomplete="upod" autofocus>

                    @error('upod')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Azuriraj kategoriju') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
