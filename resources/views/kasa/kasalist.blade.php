@extends('kasa.kasa')

@section('stavke')
    <thead>
    <th></th>
    <th></th>
    <th>@if($edit) Naplati @endif</th>
    <th>@if($edit) Broj racuna @endif</th>
    <th>Naziv</th>
    <th>Kolicina</th>
    <th>Cena</th>
    </thead>
    <tbody id="dodatestavke">
    @if($edit)
        @foreach($racuni as $i=>$racun)
            @foreach($racun->stavke as $stavka)
                <tr class="racunRedUnselectable unselectable text-danger" id="tr{{$index++}}">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><h6>{{$stavka->artikal->Naziv}}</h6></td>
                    <td><h6 class="kolicinastavke">{{$stavka->Kolicina}}</h6></td>
                    <td><h6 class="cena">{{$stavka->cenaSaPopustom()}}</h6></td>
                </tr>
                @if($loop->last)
                    <tr style="border-bottom: 2px solid red">
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" name="zaNaplatu[]" checked value="{{$i}}"></td>
                        <td>{{$loop->parent->iteration}}</td>
                        <td></td>
                        <td>Ukupno:</td>
                        <td><h6 class="font-weight-bold">{{$racun->UkupnaCena}}</h6></td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    @endif
    </tbody>
    <script>
        $(document).ready(function () {
            {{--$("#bezPopusta").val({{$bezPopusta}})--}}

            $("#brisisve").click(function () {
                $('.racunRed :not(.unselectable)').remove();
                $("#ukupnaCena").val({{$ukupno}})
                neporuceni=0;
                if(!neporuceni)
                    $("#naplata").show();
                // popust()
            })
        })
    </script>
@endsection
