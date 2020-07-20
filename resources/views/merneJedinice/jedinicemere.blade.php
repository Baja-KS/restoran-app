@extends('layouts.welcome')

@section('content')
    <a href="{{route('home')}}" class="btn btn-success">Nazad</a>
    <div class="col-md-4 justify-content-lg-start px-lg-5">
        <h2>Jedinice mere</h2>
        <hr>
        <table>
            @forelse($jedinice as $jedinica)
                <tr>
                    <td><h4>{{$jedinica->Naziv}}</h4></td>
                    <td><a href="{{route('editJedinicamere',$jedinica->JMID)}}" class="btn btn-warning">Edit</a></td>
                    <td><form action="{{route('destroyJedinicamere',$jedinica->JMID)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form></td>
                </tr>
            @empty
                <p>Nema dodatih jedinica mere</p>
            @endforelse
        </table>
    </div>
    <div class="col-md-4 ml-5 float-lg-right px-lg-5">
        <div class="card-body">
            <form method="POST" action="{{ route('storeJedinicamere') }}">
                @csrf

                <div class="form-group row">
                    <label for="sjm" class="col-md-4 col-form-label text-md-right">{{ __('Merna jedinica') }}</label>

                    <div class="col-md-6">
                        <input id="sjm" type="text" class="form-control @error('sjm') is-invalid @enderror" name="sjm" value="{{ old('sjm') }}" required autocomplete="sjm" autofocus>

                        @error('sjm')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Dodaj mernu jedinicu') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
