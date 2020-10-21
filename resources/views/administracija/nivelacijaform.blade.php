@extends('administracija.base')

@section('tab-content')
    <livewire:form-nivelacija :edit="$edit" :nivelacija="$nivelacija" :dokument="$nivelacija ?? 2" :brNivelacije="$brNivelacije" :datumNivelacije="$datumNivelacije"/>
@endsection
