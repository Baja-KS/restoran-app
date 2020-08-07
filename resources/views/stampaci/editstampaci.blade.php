@extends('stampaci.stampaci')

@section('stampaci')
    <div class="card-body">
        <form method="POST" action="{{ route('updateStampac',$stampac->StampacID) }}">
            @csrf
            @method('PATCH')
            <div class="form-group row">
                <label for="naziv" class="col-md-4 col-form-label text-md-right">{{ __('Naziv') }}</label>

                <div class="col-md-6">
                    <input id="naziv" type="text" class="form-control @error('naziv') is-invalid @enderror" name="naziv" value="{{ $stampac->Naziv }}" required autocomplete="naziv" autofocus>

                    @error('naziv')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="akcija" class="col-form-label">Mesto stampaca:</label>
                <select id="akcija" name="akcija">
                    <option value="" selected disabled>Izaberi akciju</option>
                    @foreach($akcije as $akcija)
                        <option value="{{$akcija}}" @if($stampac->AkcijaStampaca==$akcija) selected @endif>{{$akcija}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Izmeni stampac') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
