@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <div class="col-md-4 justify-content-lg-start px-lg-5">
        <h2>Glavne kategorije</h2>
        <hr>
        <table>
        @forelse($kategorije as $kategorija)
            <tr>
                <td><a href="{{route('indexPodkategorija',$kategorija->SifKat)}}" class=""><h4>{{$kategorija->Naziv}}</h4></a></td>
                <td><a href="{{route('editKategorija',$kategorija->SifKat)}}" class="btn btn-warning">Edit</a></td>
                <td><form action="{{route('destroyKategorija',$kategorija->SifKat)}}" method="POST">
                     @csrf
                     @method('DELETE')
                      <button class="btn btn-danger">Delete</button>
                    </form></td>
            </tr>
        @empty
            <p>Nema nijedne glavne kategorije</p>
        @endforelse
        </table>
    </div>
    <div class="col-md-4 ml-5 float-lg-right px-lg-5">
        <div class="card-body">
            <form method="POST" action="{{ route('storeKategorija') }}">
                @csrf

                <div class="form-group row">
                    <label for="skat" class="col-md-4 col-form-label text-md-right">{{ __('Ime glavne kategorije') }}</label>

                    <div class="col-md-6">
                        <input id="skat" type="text" class="form-control @error('skat') is-invalid @enderror" name="skat" value="{{ old('skat') }}" required autocomplete="skat" autofocus>

                        @error('skat')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Dodaj glavnu kategoriju') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
