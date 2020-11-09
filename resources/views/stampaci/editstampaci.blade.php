@extends('stampaci.stampaci')

@section('stampaci')
    <div class="card-body">
        <form method="POST" action="{{ route('updateStampac',$stampac->StampacID) }}">
            @csrf
            @method('PATCH')
            <div class="form-group row ">
                <label for="naziv" class="col-form-label text-light">Naziv stampaca:</label>
{{--                <select id="naziv" name="naziv">--}}
{{--                    <option value="" selected disabled>Izaberi stampac</option>--}}
{{--                    @foreach($dostupniStampaci as $dstampac)--}}
{{--                        <option value="{{$dstampac}}" @if($dstampac==$stampac->Naziv) selected @endif>{{$dstampac}}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
                <input type="text" name="naziv" id="naziv" required value="{{$stampac->Naziv}}">
            </div>
            <div class="form-group row">
                <label for="akcija" class="col-form-label text-light">Mesto stampaca:</label>
                <select id="akcija" name="akcija">
                    <option value=""  disabled>Izaberi akciju</option>
                    <option value="{{$stampac->AkcijaStampaca}}" selected>{{$stampac->AkcijaStampaca}}</option>
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
                    <a href="{{route('indexFirma')}}" class="btn btn-success">Nazad</a>
                </div>
            </div>
        </form>
    </div>
@endsection
