@extends('administracija.base')

@section('tab-content')
    <livewire:lista-racuna :gotovinski="$gotovinski" />
@endsection
