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
                        <div class="btn-group">
                            <a class="btn btn-xs btn-default text-primary mx-1 shadow" data-bs-toggle="modal"
                            data-bs-target="#modalContenedor{{ $cotizacion->id }}" title="{{ $cotizacion->id }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                        </a>
                            <a href="{{ route('admin.especialistas.edit', $cotizacion->id) }}"
                                class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </a>
                        </div>

                    </td>
                    @include('admin.especialistas.edit')

                </tr>
            @endforeach
            
        </tbody>

    </x-table>

</x-adminlte-card>
