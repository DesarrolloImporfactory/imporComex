@extends('adminlte::page')

@section('title', 'Imprimir')

@section('content_header')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center ">
            <div>
                <p><b>Cotizador {{ $cotizacion->pais->nombre_pais }}</b></p>
                <p>{{ $cotizacion->proceso }} de 4 <strong> Completado</strong></p>

            </div>
            <x-adminlte-progress theme="warning" value=75 animated with-label />
        </div>
        <div class="col-md-3">
        </div>
    </div>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <a href="https://walink.co/e40e8e" title="Deseas que un experto de ayude a calcular tus impuestos?" class="float"
        target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>
    <style>
        .float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }

        .float:hover {
            text-decoration: none;
            color: #25d366;
            background-color: #fff;
        }

        .my-float {
            margin-top: 16px;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <a href="{{ route('admin.cotizaciones.show', $cotizacion->usuario_id) }}" class="btn btn-warning float-left"><i
                    class="fa-solid fa-list-check"></i> Mis cotizaciones</a>
            <a href="{{ route('admin.showProv', $cotizacion->id) }}" class="btn btn-dark float-right"><i
                    class="fa-solid fa-arrow-right"></i> Siguiente</a>
        </div>
        <div class="col-md-1"></div>
    </div><br>

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">


            <x-adminlte-card title="Visualizar detalles de tu cotizacion" theme="dark">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="btn-group">

                            <a href="{{ route('cotizacion.download', $cotizacion->id) }}"
                                class="btn btn-xs btn-default text-danger mx-1 shadow" title="Descargar">
                                <i class="fa-solid fa-file-pdf"></i> Descargar Archivo
                            </a>
                            <a class="btn btn-xs btn-default text-teal mx-1 shadow" data-bs-toggle="modal"
                                data-bs-target="#PDF" title="Revisar">
                                <i class="fa-solid fa-eye"></i> Ver Archivo
                            </a>
                            <a class="btn btn-xs btn-default text-teal mx-1 shadow" data-bs-toggle="modal"
                                data-bs-target="#ticket" title="Revisar">
                                <i class="fa-solid fa-eye"></i> Ver Tickets
                            </a>
                        </div>
                    </div>
                </div><br>
                <table class="table table-striped">
                    <thead class="table-warning">
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Impuesto Unitario</th>
                            <th>Logistica Unitaria</th>
                            <th>Divisa unitario</th>
                            <th>Producto unitario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $item)
                            <tr>
                                <td>{{ $item->insumo->id }}</td>
                                <td>{{ $item->insumo->nombre }}</td>
                                <td>{{ $item->cantidad }}</td>
                                <td>{{ $item->precio }}</td>
                                <td>{{ number_format($item->Impuestos / $item->cantidad, 2) }}</td>
                                <td>{{ number_format($cotizacion->total_logistica / $cotizacion->cantidad_productos, 2) }}
                                </td>
                                
                                <td>{{ number_format($item->divisas / $item->cantidad, 2) }}
                                </td>
                                <td>{{ number_format($item->Impuestos / $item->cantidad +$cotizacion->total_logistica / $cotizacion->cantidad_productos+$item->divisas / $item->cantidad, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <table class="table table-striped">
                    <thead class="table-warning">
                        <tr>
                            <th>DESCRIPCION</th>
                            <th>INFORMACION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>CBM Total: </b></td>
                            <td>{{ $cotizacion->volumen }}</td>
                        </tr>
                        <tr>
                            <td><b>Peso bruto total: </b></td>
                            <td>{{ $cotizacion->peso }}</td>
                        </tr>
                        <tr>
                            <td><b>Lugar de entrega: </b></td>
                            <td>{{ $cotizacion->ciudad->nombre_provincia }} - {{ $cotizacion->ciudad->nombre_canton }} -
                                {{ $cotizacion->direccion }}
                            </td>
                        </tr>

                    </tbody>
                </table>
                <table class="table table-striped">
                    <thead class="table-danger">
                        <tr>
                            <th>GASTOS DE IMPORTACION</th>
                            <th>PRECIO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>Total Servicio Logístico</b></td>
                            <td>{{ $cotizacion->total_logistica }}$</td>
                        </tr>
                        <tr>
                            <td><b>Impuestos apróx. </b></td>
                            <td>{{ $cotizacion->total_impuesto }}$</td>
                        </tr>
                        <tr>
                            <td><b>Valor de compra. </b></td>
                            <td>{{ $cotizacion->total_fob }}$</td>
                        </tr>
                        <tr>
                            <td><b>Gtos. TOTAL A PAGAR: </b></td>
                            <td>{{ $cotizacion->total }}$</td>
                        </tr>

                    </tbody>
                </table>
            </x-adminlte-card>
        </div>
        <div class="col-md-1"></div>
        <div class="modal fade" id="agregarProveedor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">ASIGNAR PROVEEDOR </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="class1">
                            <ul id="errores">

                            </ul>
                        </div>
                        <form action="" id="formAsignar">
                            @csrf
                            <input type="hidden" id="cotizacion" name="cotizacion" value="{{ $cotizacion->id }}">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group formAsignar">
                                <label for="">Seleccionar proveedor: </label>
                                <select data-width="100%" name="proveedor_id" id="proveedor_id">
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formAsignar">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.cotizacion')
    @include('components.ticket')


@stop
