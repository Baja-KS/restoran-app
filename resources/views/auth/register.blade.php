@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
     <style>
         .container {
             display: flex;
             align-items: center;
         }
     </style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-danger text-md-right">{{ __('Ime') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="uid" class="col-md-4 col-form-label text-danger text-md-right">{{ __('Lozinka') }}</label>

                <div class="col-md-6">
                    <input id="uid" type="password" class="form-control @error('uid') is-invalid @enderror" name="uid" value="{{ old('uid') }}" required autocomplete="uid" autofocus>

                    @error('uid')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="ob" class="col-md-4 col-form-label text-danger text-md-right">{{ __('Objekat') }}</label>

                <div class="col-md-6">
                    <input id="ob" type="number" class="form-control @error('ob') is-invalid @enderror" name="ob" value="{{ old('op') }}" required autocomplete="ob">

                    @error('ob')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="fir" class="col-md-4 col-form-label text-danger text-md-right">{{ __('Firma') }}</label>

                <div class="col-md-6">
                    <input id="fir" type="number" class="form-control @error('fir') is-invalid @enderror" name="fir" value="{{ old('fir') }}" required autocomplete="fir">

                    @error('fir')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="ka" class="col-md-4 col-form-label text-danger text-md-right">{{ __('Kasa') }}</label>

                <div class="col-md-6">
                    <input id="ka" type="number" class="form-control @error('ka') is-invalid @enderror" name="ka" value="{{ old('ka') }}" required autocomplete="ka">

                    @error('ka')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-danger text-md-right" for="admin">Admin:</label>
                <input type="checkbox" class="form-control" name="admin" value="1">
            </div>

        <!--
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
            </div>
        </div>
-->
        <!--
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
            </button>
        </div>
    </div>
-->
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>
            </div>
        </form>
        </div>
        <!--
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">

                </div>
            </div>
        </div>
        -->

    </div>
</div>
@endsection
