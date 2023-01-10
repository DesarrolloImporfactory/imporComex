@extends('adminlte::page')

@section('title', 'Calculadora colombia')

@section('content_header')

    @if ($mensaje == 'false')
        <script>
            Swal.fire({
                title: '<strong><u>lo sentimos mucho</u></strong>',
                icon: 'error',
                html: 'En carga GRUPAL no se puede cargar este tipo de producto. Dirigete al siguiente enlace para realizar una cotizacion invidual:</b>  ' +
                    '<a href="{{ route('admin.individual.create') }}" >Cotizacion invididual</a> ',
                showCloseButton: false,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> OK!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down'
            })
        </script>
    @endif
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

    {{-- <div class="row ">
        <x-adminlte-info-box title="Progreso de tu Importación" text="{{ $cotizacion->proceso }}/4"
            icon="fas fa-lg fa-tasks text-orange" theme="warning" icon-theme="dark" progress=50 progress-theme="dark"
            description="50% para completa tu solicitud" />
    </div> --}}
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center ">
            <div>
                <p><b>Cotizador {{ $cotizacion->pais->nombre_pais }}</b></p>
                <p>{{ $cotizacion->proceso }} de 4 <strong> Completado</strong></p>

            </div>
            <x-adminlte-progress theme="secondary" value=50 animated with-label />
        </div>
        <div class="col-md-3">
        </div>
    </div>


@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('validacion.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $cotizacion->id }}" name="idCotizacion">
                <div class="row">
                    <div class="col-md-12">
                        <x-adminlte-button label="Siguiente" theme="dark" icon="fa-solid fa-arrow-right"
                            class="float-right" type="sumbit" />
                    </div>
                </div><br>
                <x-adminlte-card title="Detalle de cotizacion" theme="dark">
                    <div class="row">
                        <div class="col-md-7">

                            @include('admin.calculadoras.createValidacion')

                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body">



                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Productos: </label>
                                                <input type="text" class="form-control "
                                                    value="{{ $cotizacion->producto }}" disabled>
                                            </div>



                                            <div class="form-group">
                                                <label for="">Peso bruto : </label>
                                                <input type="text" class="form-control " value="{{ $cotizacion->peso }}"
                                                    disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Tipo de Carga: </label>
                                                <input type="text" class="form-control "
                                                    value="{{ $cotizacion->carga->tipoCarga }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Direccion de entrega: </label>
                                                <input type="text" class="form-control "
                                                    value="{{ $cotizacion->direccion }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Ciudad de entrega:</label>
                                                <input type="text" class="form-control "
                                                    value="{{ $cotizacion->ciudad_entrega }}" disabled>
                                            </div>


                                            <div class="form-group">
                                                <label for="">Precio total de compra:</label>
                                                <input type="text" class="form-control "
                                                    value="{{ $cotizacion->precio_china }}" disabled>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Dimensiones/Volumen:</label>
                                                <input type="text" class="form-control "
                                                    value="{{ $cotizacion->volumen }}" disabled>
                                            </div>
                                            <div class="form-group" style="color: red">
                                                <label for="">Total valor logistica: </label>
                                                <input type="text" class="form-control "
                                                    value="{{ $cotizacion->total_logistica }}" disabled style="color: red">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </x-adminlte-card>
            </form>
        </div>
    </div>
@stop
