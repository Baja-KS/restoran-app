@extends('administracija.base')

@section('tab-content')
    <livewire:kasa-zakljucavanje/>

    <script>
        window.livewire.on('potvrdiIzmene', () => {
            $('#potvrdiIzmene').modal('show');
        });
        window.livewire.on('cancelIzmene', () => {
            $('#potvrdiIzmene').modal('hide');
        });
    </script>
@endsection
