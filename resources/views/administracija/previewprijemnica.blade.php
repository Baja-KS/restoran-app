@extends('administracija.base')

@section('tab-content')
    <object data="/Restoran/public/prijemnica.pdf" type="application/pdf" width="100%" height="550px">
        alt : <a href="/Restoran/public/prijemnica.pdf">firmapreview.pdf</a>
    </object>
    <div>
        <a href="{{route('stampaPrijemnica')}}" class="btn btn-primary">Stampaj</a>
        <a href="{{route('indexPrijemnica')}}" class="btn btn-warning">Nazad</a>
    </div>
@endsection
