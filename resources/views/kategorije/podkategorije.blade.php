@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <a href="{{route('indexKategorija')}}" class="btn btn-success">Nazad</a>
    <div class="col-md-4 justify-content-lg-start px-lg-5">
        <h2>{{$kategorija->Naziv}}</h2>
        <hr>
        <h2>Podkategorije</h2>
        <hr>
        <table>
            @forelse($podkategorije as $podkategorija)
                <tr>
                    <td><h4>{{$podkategorija->Naziv}}</h4></td>
                    <td><a href="{{route('editPodkategorija',$podkategorija->SifKat)}}" class="btn btn-warning">Edit</a></td>
                    <td><form action="{{route('destroyPodkategorija',$podkategorija->SifKat)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form></td>
                </tr>
            @empty
                <p>Glavna kategorija {{$kategorija->Naziv}} nema nijednu podkategoriju</p>
            @endforelse
        </table>
        {{$podkategorije->links()}}}
    </div>
    <div class="col-md-4 ml-5 float-lg-right px-lg-5">
        <div class="card-body">
            <form method="POST" action="{{ route('storePodkategorija',$kategorija) }}">
                @csrf

                <div class="form-group row">
                    <label for="spod" class="col-md-4 col-form-label text-md-right">{{ __('Ime  podkategorije') }}</label>

                    <div class="col-md-6">
                        <input id="spod" type="text" class="form-control @error('spod') is-invalid @enderror" name="spod" value="{{ old('spod') }}" required autocomplete="spod" autofocus>

                        @error('spod')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Dodaj podkategoriju') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
