<x-adminlte-card title="Gestionar cotizaciones asignadas" theme="dark" icon="fa-solid fa-handshake-angle">
    @php    
$heads = ['ID','BarCode', 'Estado','Usuario','Especialista', 'Pais','Modalidad','Carga','Producto','tProductos','Precio China','Contenedor','Incoterms','Tarifa','Gastos-EXW','Seguro','Proceso','Origen','Peso','Volumen','Dirección','Ciudad','Ruta','Total','Acciones'];    
$config['dom'] = '<"row" <"col-sm-7" B> <"col-sm-5 d-flex justify-content-end" i> >
                  <"row" <"col-12" tr> >
                  <"row" <"col-sm-12 d-flex justify-content-start" f> >';
$config['paging'] = true;
$config['with-buttons'] = true;
$config["lengthMenu"] = [ 10, 50, 100, 500];
@endphp

    <x-adminlte-datatable :heads="$heads" head-theme="light"  id="table2" :config="$config">

        @foreach ($listadoCotizaciones as $cotizacion)
            <tr>
                <td>
                    <a class="" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item " href=" " data-bs-toggle="modal"
                                    data-bs-target="#modalContenedor{{ $cotizacion->id }}"><i
                                        class="bi bi-pencil-square"></i> Editar
                                </a>
                        </li>
                        <li>
                            <!-- Modal eliminar -->

                            <!-- Modal editar -->
                        </li>

                    </ul>
                </td>
                <th scope="row">{!! $cotizacion->id !!}</th>
                <td>{!! $cotizacion->barcode !!}</td>
                <td>{!! $cotizacion->estado !!}</td>
                <td>{!! $cotizacion->usuario->name !!}</td>
                <td>{!! $cotizacion->especialista->name!!}</td>
                <td>{!!$cotizacion->pais->nombre_pais !!}</td>
                <td>{!! $cotizacion->modalidad->modalidad !!}</td>
                <td>{!! $cotizacion->carga->tipoCarga !!}</td>
                <td>{!! $cotizacion->producto!!}</td>
                <td>{!! $cotizacion->total_productos !!}</td>
                <td>{!! $cotizacion->precio_china !!}</td>
                <td>{!! $cotizacion->contenedor->name!!}</td>
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

                
            </tr>
            <!-- Modal editar -->
            @include('admin.especialistas.edit')
            <!-- Modal editar -->
        @endforeach

    </x-adminlte-datatable>
</x-adminlte-card>