@extends('administracija.base')

@section('tab-content')
    <livewire:lista-nivelacija/>

    <script type="text/javascript">

        window.livewire.on('printNivelacija', () => {
            $('#printPreview').modal('hide');
            window.open('/Restoran/public/nivelacija.pdf')
        });
        window.livewire.on('previewNivelacija', () => {

            $('#printPreview').modal('show');
        });
        window.livewire.on('renderNivelacija',()=>{
            $("#previewModalBody").empty()
            let html=''
            html+='<object data="/Restoran/public/nivelacija.pdf" type="application/pdf" width="100%">\n' +
                '                        alt : <a href="/Restoran/public/nivelacija.pdf">nivelacija.pdf</a>\n' +
                '                    </object>'
            $("#previewModalBody").append(html)
        })


    </script>
@endsection
