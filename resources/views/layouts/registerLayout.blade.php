@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <style>
        .container {
            display: flex;
            align-items: center;
        }
    </style>
    <div class="container" style="background-color: saddlebrown">
        <div class="col-6  text-light" >
            @yield('userForm')
        </div>
        <div class="col-6">
            <livewire:korisnici-lista/>
        </div>
    </div>
@endsection
