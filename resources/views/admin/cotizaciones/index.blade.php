@extends('adminlte::page')
@section('title', 'Cotizaciones')

@section('content_header')

    <x-adminlte-info-box title="Gestion de Cotizaciones" text="total de cotizaciones: 150"
        icon="fas fa-lg fa-tasks text-orange" theme="warning" icon-theme="dark" description="Especialista: UserName" />
@stop

@section('content')
@php    
$heads = ['ID','BarCode','Usuario','Pais','Modalidad','Carga','Producto','Cartones','tProductos','Precio China','Contenedor','Incoterms','Tarifa','Gastos-EXW','Seguro','Proceso','Origen','Peso','Volumen','Dirección','Ciudad','Ruta','Total','Acciones'];    
$config['dom'] = '<"row" <"col-sm-7" B> <"col-sm-5 d-flex justify-content-end" i> >
                  <"row" <"col-12" tr> >
                  <"row" <"col-sm-12 d-flex justify-content-start" f> >';
$config['paging'] = true;
$config['with-buttons'] = true;
$config["lengthMenu"] = [ 10, 50, 100, 500];
@endphp

    <x-adminlte-datatable :heads="$heads" head-theme="light" theme="warning" id="table2" :config="$config">

        @foreach ($cotizaciones as $cotizacion)
            <tr>
                <th scope="row">{!! $cotizacion->id !!}</th>
                <td>{!! $cotizacion->barcode !!}</td>
                <td>{!! $cotizacion->usuario_id !!}</td>
                <td>{!!$cotizacion->pais_id !!}</td>
                <td>{!! $cotizacion->modalidad_id !!}</td>
                <td>{!! $cotizacion->cargas_id !!}</td>
                <td>{!! $cotizacion->producto!!}</td>
                <td>{!! $cotizacion->total_cartones !!}</td>
                <td>{!! $cotizacion->total_productos !!}</td>
                <td>{!! $cotizacion->precio_china !!}</td>
                <td>{!! $cotizacion->contenedor_id!!}</td>
                <td>{!! $cotizacion->incoterms_id !!}</td>
                <td>{!! $cotizacion->tarifa_id !!}</td>
                <td>{!! $cotizacion->gastos_exw!!}</td>
                <td>{!! $cotizacion->seguro!!}</td>
                <td>{!! $cotizacion->proceso !!}</td>
                <td>{!! $cotizacion->origen!!}</td>
                <td>{!! $cotizacion->peso!!}</td>
                <td>{!! $cotizacion->volumen!!}</td>
                <td>{!! $cotizacion->direccion !!}</td>
                <td>{!! $cotizacion->ciudad_entrega!!}</td>
                <td>{!! $cotizacion->ruta !!}</td>
                <td>{!! $cotizacion->total!!}</td>

                <td>
                    <a class="" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item " href=" "><i
                                    class="bi bi-pencil-square"></i> Editar</a>
                            </a>
                        </li>
                        <li>
                            <!-- Modal eliminar -->

                            <!-- Modal editar -->
                        </li>

                    </ul>
                </td>
            </tr>
            <!-- Modal editar -->

            <!-- Modal editar -->
        @endforeach

    </x-adminlte-datatable>

@stop
