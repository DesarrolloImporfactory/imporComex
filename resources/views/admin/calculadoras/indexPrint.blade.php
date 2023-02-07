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
            <a href="{{ route('admin.cotizaciones.show', $cotizacion->usuario_id) }}" class="btn btn-dark float-right"><i
                    class="fa-solid fa-list-check"></i> Mis cotizaciones</a>
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
                          
                            <a href="{{route('cotizacion.download',$cotizacion->id)}}" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Descargar">
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
                            <th>Porcentaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($productos as $item)
                            <tr>
                                <td>{{ $item->insumo->id }}</td>
                                <td>{{ $item->insumo->nombre }}</td>
                                <td>{{ $item->insumo->cantidad }}</td>
                                <td>{{ $item->insumo->precio }}</td>
                                <td>{{ $item->insumo->porcentaje }}</td>
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
                            <td><b>Partida arancelaria:</b></td>
                            <td>Pendiente</td>
                        </tr>
                        <tr>
                            <td><b>CBM Total: </b></td>
                            <td>{{ $cotizacion->volumen }}</td>
                        </tr>
                        <tr>
                            <td><b>Peso bruto total: </b></td>
                            <td>{{ $cotizacion->peso }}</td>
                        </tr>
                        <tr>
                            <td><b>Valor Factura EXW + envío a bodegas: </b></td>
                            <td>Pendiente</td>
                        </tr>
                        <tr>
                            <td><b>Lugar de entrega: </b></td>
                            <td>{{ $cotizacion->ciudad->nombre_provincia }} - {{ $cotizacion->ciudad->nombre_canton }}
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
                            <td><b>Gtos. TOTAL A PAGAR: </b></td>
                            <td>{{ $cotizacion->total }}$</td>
                        </tr>

                    </tbody>
                </table>
            </x-adminlte-card>
        </div>
        <div class="col-md-1"></div>
    </div>

    @include('components.cotizacion')
    @include('components.ticket')
@stop
