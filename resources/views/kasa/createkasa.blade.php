@extends('kasa.kasa')

@section('stavke')
    <thead>
    <th></th>
    <th></th>
    <th>Naziv</th>
    <th>Kolicina</th>
    <th>Cena</th>
    </thead>
    <tbody id="dodatestavke">


    </tbody>
    <script>
        $(document).ready(function ()
        {
            $("#brisisve").click(function () {
                $('.racunRed :not(.unselectable)').remove();
                $("#bezPopusta").val(0)
                $("#ukupnaCena").val(0)

            })
        })
    </script>
@endsection
