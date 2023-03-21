@extends('adminlte::page')
@section('title', 'Cotizaciones')

@section('content_header')
    @if (Session::has('mensaje'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ Session::get('mensaje') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    <div class="row">
        <div class="col-md-12">
            <x-adminlte-small-box title="Aprobadas" text="total : {{ $aprobadas }}" icon="fas fa-face-smile " theme="primary"
                url="{{ route('admin.cotizaciones.show', Auth::user()->id) }}" url-text="Regresar"
                id="aprobadas" />
        </div>
    @stop

    @section('content')

        <form action="{{ route('admin.dashboard.totalCotizaciones') }}" method="post" id="form">
            @csrf
            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
        </form>

        @include('admin.cotizaciones.table')

    @stop

    @push('js')
        <script>
            $(document).ready(function() {

                let sBox2 = new _AdminLTE_SmallBox('aprobadas');

                let updateBox2 = () => {
                    // Stop loading animation.
                    sBox2.toggleLoading();
                    // Update data.
                    $.ajax({
                        url: "{{ route('admin.dashboard.totalCotizaciones') }}",
                        method: "POST",
                        data: $("#form").serialize()
                    }).done(function(res) {

                        var respuesta = res.aprobadas;

                        let rep = 'Aprobadas';
                        let idx = respuesta < 10 ? 0 : (respuesta > 50 ? 2 : 1);
                        let text = 'total : ' + respuesta + ' - ' + ['Bajo', 'Medio', 'Alto'][idx];
                        let icon = 'fas fa-face-smile ' + ['text-dark', 'text-light', 'text-warning'][idx];
                        //let url = ['url1', 'url2', 'url3'][idx];

                        let data = {
                            text,
                            title: rep,
                            icon
                        };
                        sBox2.update(data);
                    });

                };

                let startUpdateProcedure = () => {
                    // Simulate loading procedure.
                    sBox2.toggleLoading();
                    // Wait and update the data.
                    setTimeout(updateBox2, 2000);
                };
                setInterval(startUpdateProcedure, 10000);
            })
        </script>
    @endpush
