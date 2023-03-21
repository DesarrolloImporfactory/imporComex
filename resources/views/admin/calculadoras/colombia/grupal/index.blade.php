@extends('adminlte::page')

@section('title', 'Calculadora colombia')

@section('content_header')

<div class="row ">
    <div class="col-sm-12">
        <div class="alert alert-warning alert-dismissible fade show" role="alert" >
            <strong>Cotizador Colombia modalidad Grupal, </strong> !Recuerde que puede gestionar sus cotizaciones.
            
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6 text-center ">
        <div>
            <p>PROGRESO DE TU IMPORTACION</p>
            <p>3 de 4 <strong> Completado</strong></p>
            
        </div>
        <x-adminlte-progress theme="secondary" value=50 animated with-label />
    </div>
    <div class="col-md-3">
    </div>
</div>


@stop

@section('content')
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                Tarifa Flete modalidad 'GRUPAL', usuario: {{ Auth::user()->name }}

            </div>
            <div class="card-body">
                <x-table>
                    <thead >
                        <tr class="table-dark">
                            <th>#</th>
                            <th>Producto</th>
                            <th>Peso</th>
                            <th>Carga</th>
                            <th>Ciudad de entrega</th>
                            <th>Cartones</th>
                            <th>Vol.</th>
                            <th>Proceso</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cotizaciones as $cotizacion)
                            @if ($cotizacion->tipo_carga = '1')
                                <tr>
                                    <td>{{ $cotizacion->id }}</td>
                                    <td>{{ $cotizacion->producto }}</td>
                                    <td>{{ $cotizacion->peso }}</td>
                                    <td>{{ $cotizacion->carga->tipoCarga }}</td>
                                    <td>{{ $cotizacion->ciudad_entrega }} - {{ $cotizacion->direccion }} </td>
                                    <td>{{ $cotizacion->total_cartones }}</td>
                                    <td>{{ $cotizacion->volumen }}</td>
                                    <td><div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-label="Example with label" style="width: 50%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">50%</div>
                                      </div></td>
                                    <td>{{ $cotizacion->total }}</td>
                                    <td>Eliminar</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </x-table>
            </div>

        </div>
    </div>
    <div class="col-md-1"></div>
</div>
@stop