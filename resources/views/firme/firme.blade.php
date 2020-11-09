@extends('layouts.welcome')

@section('content')
    @include('layouts.bezstolova')
    <h2 class="text-light">Firme</h2>
    <hr>
    <div class="container-fluid" style="background-color: saddlebrown">
        <div class="container col-md-4 justify-content-lg-start px-lg-5">

            <table class="table table-borderless  text-light">
                @if($firme->count()>0)
                    <thead>
                    <tr>
                        <th>Naziv</th>
                        <th>Adresa</th>
                        <th>Mesto</th>
                        <th>PIB</th>
                    </tr>
                    </thead>
                @endif
                @forelse($firme as $firma)
                    <tr>
                        <td><h4>{{$firma->Naziv}}</h4></td>
                        <td><h4>{{$firma->Adresa}}</h4></td>
                        <td><h4>{{$firma->Mesto}}</h4></td>
                        <td><h4>{{$firma->PIB}}</h4></td>
                        <td><a href="{{route('editFirma',$firma->FirmaID)}}" class="btn btn-warning">Edit</a></td>
                        <td><form action="{{route('destroyFirma',$firma->FirmaID)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form></td>
                    </tr>
                @empty
                    <p>Nema dodatih firmi i ogranaka</p>
                @endforelse
            </table>
        </div>
        <div class="col-md-6 container float-lg-right">
            @yield('firme')
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(".dropdown").select2()
        })
    </script>
@endsection
