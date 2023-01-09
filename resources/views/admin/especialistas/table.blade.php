<x-adminlte-card title="Gestionar cotizaciones asignadas" theme="dark" icon="fa-solid fa-handshake-angle">


    <x-table>
        <thead class="text-center">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Estado</th>
                <th scope="col">Cliente</th>
                <th scope="col">Especialista</th>
                <th scope="col">Pais</th>
                <th scope="col">Modalidad</th>
                <th scope="col">Origen</th>
                <th scope="col">Ciudad entrega</th>
                <th scope="col">Total</th>
                <th scope="col">Acciones</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($listadoCotizaciones as $cotizacion)
                <tr>
                    <th scope="row">{{ $cotizacion->id }}</th>
                    <td>{{ $cotizacion->estado }}</td>
                    <td>{{ $cotizacion->usuario->name }}</td>
                    <td>{!! $cotizacion->especialista->name !!}</td>
                    <td>{{ $cotizacion->pais->nombre_pais }}</td>
                    <td>{!! $cotizacion->modalidad->modalidad !!}</td>
                    <td>{{ $cotizacion->origen }}</td>
                    <td>{{ $cotizacion->direccion }}/{{ $cotizacion->ciudad_entrega }}</td>
                    <td>{{ $cotizacion->total }}</td>
                    <td>
                        <a class="" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bars"></i>
                        </a>
                        <ul class="dropdown-menu text-center">
                            <li>
                                <a class="dropdown-item   text-teal  " data-bs-toggle="modal"
                                    data-bs-target="#modalContenedor{{ $cotizacion->id }}"
                                    title="{{ $cotizacion->id }}"><i class="fa fa-lg fa-fw fa-pen"></i> Editar</a>
                                </a>

                            </li>
                            <li>
                                <a href="{{ route('admin.especialistas.edit', $cotizacion->id) }}"
                                    class="dropdown-item   text-primary " title="Details">
                                    <i class="fa fa-lg fa-fw fa-eye"></i>Detalles
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('editar.paso1', $cotizacion->id) }}"
                                    class="dropdown-item   text-warning " title="Details">
                                    <i class="fa-solid fa-circle"></i></i>Paso 1
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('editar.paso2', $cotizacion->id) }}"
                                    class="dropdown-item   text-warning " title="Details">
                                    <i class="fa-solid fa-circle"></i></i></i>Paso 2
                                </a>
                            </li>

                        </ul>
                    </td>
                    @include('admin.especialistas.edit')

                </tr>
            @endforeach

        </tbody>

    </x-table>

</x-adminlte-card>
