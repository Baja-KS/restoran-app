@extends('stampaci.stampaci')

@section('stampaci')
    @if(\App\Stampac::all()->count()<4)
    <div class="card-body">
        <form method="POST" action="{{ route('storeStampac') }}">
            @csrf

            <div class="form-group row">
                <label for="naziv" class="col-form-label">Naziv stampaca:</label>
                <select id="naziv" name="naziv">
                    <option value="" selected disabled>Izaberi stampac</option>
                    @foreach($dostupniStampaci as $stampac)
                        <option value="{{$stampac}}">{{$stampac}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group row">
                <label for="akcija" class="col-form-label">Mesto stampaca:</label>
                <select id="akcija" name="akcija">
                    <option value="" selected disabled>Izaberi akciju</option>
                    @foreach($akcije as $akcija)
                        <option value="{{$akcija}}">{{$akcija}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Dodaj stampac') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif
@endsection
