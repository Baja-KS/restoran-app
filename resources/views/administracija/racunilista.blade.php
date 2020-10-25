@extends('administracija.base')

@section('tab-content')
    <livewire:lista-racuna :gotovinski="$gotovinski" />

    <script type="text/javascript">

        window.livewire.on('printRacun', () => {
            $('#printPreview').modal('hide');
        });
        window.livewire.on('previewRacun', () => {

            $('#printPreview').modal('show');
        });
        window.livewire.on('renderNoviRacun',()=>{
            $("#previewModalBody").empty()
            let html=''
            html+='<object data="/Restoran/public/racunfirma.pdf" type="application/pdf" width="100%">\n' +
                '                        alt : <a href="/Restoran/public/racunfirma.pdf">firmapreview.pdf</a>\n' +
                '                    </object>'
            $("#previewModalBody").append(html)
        })


    </script>

@endsection
