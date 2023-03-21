@extends('adminlte::page')

@section('title', 'Cotizacion Individual')

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
            <div class="alert alert-light " role="alert">
                <b>COTIZACION INDIVIDUAL</b>
                <x-adminlte-button label="Siguiente" theme="dark" icon="fa-solid fa-arrow-right" class="float-right " type="sumbit"
                form="form" />
              </div>
            
        </div>
    </div>
@stop

@section('content')
    <x-adminlte-card title="Formulario de carga individual" theme="dark" icon="fas fa-lg fa-moon">
        <form action="{{ route('admin.individual.store') }}" method="post" id="form">
            @csrf
            <div class="row">
                <input type="hidden" name="usuario_id" id="" value="{{ Auth::user()->id }}">
                <div class="col-md-3">
                    <label for="">Pais de origen: </label>
                    <div class="form-group">
                        <x-adminlte-select2 name="origen_id" data-placeholder="Seleccione una opcion...">
                            <option />
                            @foreach ($paises as $item)
                                <option value="{{ $item->id }}"{{ old('origen_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nombre_pais }}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="">Pais de destino: </label>
                    <div class="form-group">
                        <x-adminlte-select2 name="destino_id" data-placeholder="Seleccione una opcion...">
                            <option />
                            @foreach ($paises as $item)
                                <option value="{{ $item->id }}"{{ old('destino_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nombre_pais }}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="">Cantidad de proveedores: </label>
                    <div class="form-group">
                        <x-adminlte-select2 name="proveedores" data-placeholder="Seleccione una opcion...">
                            <option />
                            <option value="1"{{ old('proveedores') == '1' ? 'selected' : '' }}>1</option>
                            <option value="2"{{ old('proveedores') == '2' ? 'selected' : '' }}>2</option>
                            <option value="3"{{ old('proveedores') == '3' ? 'selected' : '' }}>3</option>
                            <option value="4"{{ old('proveedores') == '4' ? 'selected' : '' }}>4</option>
                            <option value="5"{{ old('proveedores') == '5' ? 'selected' : '' }}>5</option>
                        </x-adminlte-select2>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="">Termino de negociacion: </label>
                    <div class="form-group">
                        <x-adminlte-select2 name="incoterms_id" id="incoterms" onchange="crear()"
                            data-placeholder="Seleccione una opcion...">
                            <option />
                            @foreach ($incoterms as $item)
                                <option
                                    value="{{ $item->id }} ">
                                    {{ $item->name }}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Valor de la factura: </label>
                        <input type="text" name="valor" id="" class="form-control @error('valor') is-invalid @enderror">
                        @error('valor')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Peso bruto</label>
                        <div class="input-group">
                            <input type="text" id="peso"
                                class="form-control @error('peso') is-invalid @enderror" name="peso"
                                value="{{ old('peso') }}" placeholder="Ingresar un valor o N/A">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa-sharp fa-solid fa-k"></i><i
                                        class="fa-brands fa-google"></i></span>
                            </div>
                        </div>
                        @error('peso')
                            <small style="color: #d80e22ed">
                                <p>En caso de no disponer ingresar N/A</p>
                                <b>{{ $message }}</b>
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="">Productos: </label>
                    <input type="text" name="productos" id="" class="form-control @error('productos') is-invalid @enderror">
                    @error('productos')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Dimensiones/Volumen</label>
                        <div class="input-group mb-3">
                            <input type="text" name="volumen" id="volumen"
                                class="form-control decimal @error('volumen') is-invalid @enderror"
                                value="{{ old('volumen') }}" placeholder="Ingresar en CBM, mas informacion"
                                aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button title="Calculadora" class="btn btn-outline-secondary" type="button"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                        class="fa-solid fa-calculator"></i></button>
                            </div>
                        </div>
                        @error('volumen')
                            <small style="color:#d80e22ed">
                                <b>{{ $message }}</b>
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="newData">

                    </div>
                </div>
            </div>
        </form>
        @include('admin.calculadoraCBM.calculadoraPrueba')
    </x-adminlte-card>

    <script type="text/javascript">
        function crear(valor) {

            $(".newData").empty();

            valor = $("#incoterms").val();
            let tipo = '';

            if (valor == 1) {
                $('.newData').append(
                    '<div id="newRow" class="form-row">' +
                    '<div class="col-md-12">' +
                    '<label >Direccion de recogida:</label>' +
                    '<input  type="text" name="direccion"  class="form-control"  placeholder="">' +
                    '</div>' +
                    '</div>'
                );
            }

        }
    </script>

    <script>
        function ejecutar() {
            Swal.fire({
                title: '<strong><u>Información</u></strong>',
                icon: 'info',
                text: 'La dimension total de tu carga debe ser en CBM(M3), si aun no la tienes ingresa al siguiente enlace:',
                html: 'La dimension total de tu carga debe ser en CBM(M3), si aun no la tienes ingresa al siguiente enlace:</b>  ' +
                    '<a href="https://imporcomexcorp.com/calculadora-cbm" target="_blank">www.imporcomexcorp.com/calculadora-cbm</a> ',
                showCloseButton: false,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> OK!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down'
            })
        }
    </script>
@stop

@section('css')

@stop
