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
    <h3>Cotizacion Individual</h3>
<div class="row">
    <div class="col-md-12">
        <x-adminlte-button label="Siguiente" theme="dark" icon="fa-solid fa-arrow-right" class="float-right"
                type="sumbit" form="form" />
    </div>
</div>
@stop

@section('content')
    <x-adminlte-card title="Formulario de carga individual" theme="dark" icon="fas fa-lg fa-moon">
        <form action="{{route('admin.individual.store')}}" method="post" id="form">
            @csrf
            <div class="row">
                <input type="hidden" name="usuario_id" id="" value="{{ Auth::user()->id }}">
                <div class="col-md-3">
                    <label for="">Pais de origen: </label>
                    <div class="form-group">
                        <select name="origen_id" id="" class="selectpicker" title="Seleccionar">
                            @foreach ($paises as $item)
                                <option value="{{ $item->id }}"{{ old('estado') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nombre_pais }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="">Pais de destino: </label>
                    <div class="form-group">
                        <select name="destino_id" id="" class="selectpicker" title="Seleccionar">
                            @foreach ($paises as $item)
                                <option value="{{ $item->id }}"{{ old('origen') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nombre_pais }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="">Cantidad de proveedores: </label>
                    <div class="form-group">
                        <select name="proveedores" id="" class="selectpicker" title="Seleccionar">
                            <option value="1"{{ old('proveedores') == '1' ? 'selected' : '' }}>1</option>
                            <option value="2"{{ old('proveedores') == '2' ? 'selected' : '' }}>2</option>
                            <option value="3"{{ old('proveedores') == '3' ? 'selected' : '' }}>3</option>
                            <option value="4"{{ old('proveedores') == '4' ? 'selected' : '' }}>4</option>
                            <option value="5"{{ old('proveedores') == '5' ? 'selected' : '' }}>5</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="">Termino de negociacion: </label>
                    <div class="form-group">
                        <select name="incoterms_id" id="incoterms" class="selectpicker" title="Seleccionar"
                            onchange="crear()">
                            @foreach ($incoterms as $item)
                                <option
                                    value="{{ $item->id }} "{{ old('incoterms_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Valor de la factura: </label>
                        <input type="text" name="valor" id="" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="">Peso bruto: </label>
                    <input type="text" name="peso" id="" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Productos: </label>
                    <input type="text" name="productos" id="" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="">Dimensiones/Volumen</label>
                    <div class="input-group mb-3">
                        <input type="text" name="volumen" id="" class="form-control"
                            placeholder="Ingresar en CBM, mas informacion" aria-label="Recipient's username"
                            aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="ejecutar()"><i
                                    class="fa-solid fa-question"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="newData">

                    </div>
                </div>
            </div>
        </form>
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
