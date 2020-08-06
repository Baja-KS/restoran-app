@extends('kasa.kasa')

@section('stavke')
    <thead>
    <th></th>
    <th>Broj racuna</th>
    <th>Naziv</th>
    <th>Kolicina</th>
    <th>Cena</th>
    </thead>
    <tbody id="dodatestavke">
        @foreach($racuni as $racun)
            @foreach($racun->stavke as $stavka)
                <tr class="racunRedUnselectable unselectable text-danger" id="">
                    <td></td>
                    <td></td>
                    <td><h6>{{$stavka->artikal->Naziv}}</h6></td>
                    <td><h6>{{$stavka->Kolicina}}</h6></td>
                    <td><h6>{{$stavka->artikal->magacin->ZadnjaProdajnaCena}}</h6></td>
                </tr>
                @if($loop->last)
                    <tr style="border-bottom: 2px solid red">
                        <td></td>
                        <td>{{$loop->parent->iteration}}</td>
                        <td></td>
                        <td>Ukupno:</td>
                        <td><h6 class="font-weight-bold">{{$racun->UkupnaCena}}</h6></td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
    <script>
        $(document).ready(function () {
            $("#bezPopusta").val({{$bezPopusta}})

            $("#brisisve").click(function () {
                $('.racunRed :not(.unselectable)').remove();
                $("#bezPopusta").val({{$bezPopusta}})
                popust()
            })
        })
    </script>
@endsection
