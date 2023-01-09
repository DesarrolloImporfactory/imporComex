<x-adminlte-card title="Cotizaciones Individuales" theme="dark" icon="fa-sharp fa-solid fa-coins">
    <x-table>
        <thead class="text-center">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Cliente</th>
                <th scope="col">Especialista</th>
                <th scope="col">Origen</th>
                <th scope="col">Destino</th>
                <th scope="col">Producto</th>
                <th scope="col">Incoterms</th>
                <th scope="col">CBM</th>
                <th scope="col">Acciones</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($cotizacionIndividual as $cotizacion)
                <tr>
                    <th scope="row">{{ $cotizacion->id }}</th>
                    <td>{{ $cotizacion->usuario->name }}</td>
                    <td>{!! $cotizacion->especialista->name !!}</td>
                    <td>{{ $cotizacion->origen->nombre_pais }}</td>
                    <td>{{ $cotizacion->destino->nombre_pais }}</td>
                    <td>{!! $cotizacion->productos !!}</td>
                    <td>{{ $cotizacion->incoter->name}}</td>
                    <td>{{ $cotizacion->volumen }}</td>
                    <td>
                        <div class="btn-group">
                            @include('admin.cotizaciones.delete')
                            <a href="{{ route('admin.cotizaciones.edit', $cotizacion->id) }}"
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
