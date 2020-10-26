@extends('administracija.base')

@section('tab-content')
    <livewire:lager-lista :hrana="$hrana" />

    <script type="text/javascript">

        window.livewire.on('closeKartica', () => {
            $('#karticaArtikla').modal('hide');
        });
        window.livewire.on('openKartica', () => {

            $('#karticaArtikla').modal('show');
        });

    </script>
@endsection
