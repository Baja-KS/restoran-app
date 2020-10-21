@extends('merneJedinice.jedinicemere')

@section('jmform')
    <div class="card-body">
        <a href="{{route('indexJedinicamere')}}" class="btn btn-success">Nazad</a>
        <form method="POST" action="{{$edit ? route('updateJedinicamere',$jedinica->JMID) : route('storeJedinicamere')}}">
            @csrf
            @if($edit)
                @method('PATCH')
            @endif
            <div class="form-group row">
                <label for="naziv" class="col-md-4 col-form-label text-md-right">Naziv</label>

                <div class="col-md-6">
                    <input id="naziv" type="text" class="form-control @error('naziv') is-invalid @enderror" name="naziv" value="{{ $jedinica->Naziv ?? ""}}" required autocomplete="naziv" autofocus>

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
                        {{ __('Azuriraj jedinicu') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
