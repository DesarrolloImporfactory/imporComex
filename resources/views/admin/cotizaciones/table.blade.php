<x-adminlte-card title="Cotizaciones" theme="dark" icon="fa-sharp fa-solid fa-coins">
    <x-table>
        <thead class="text-center">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">ESTADO</th>
                <th scope="col">CLIENTE</th>
                <th scope="col">ESPECIALISTA</th>
                <th scope="col">MODALIDAD</th>
                <th scope="col">PESO</th>
                <th scope="col">VOLUMEN</th>
                <th scope="col">DIR.ENTREGA</th>
                <th scope="col">TOTAL</th>
                <th scope="col"></th>

            </tr>
        </thead>
        <tbody>
            @foreach ($listadoCotizaciones as $cotizacion)
                <tr>

                    <th scope="row">{{ $cotizacion->id }}</th>
                    <td>
                        @if ($cotizacion->estado == 'Pendiente')
                            <span class="badge bg-danger rounded-pill">{{ $cotizacion->estado }}</span>
                        @else
                            <span class="badge bg-teal rounded-pill">{{ $cotizacion->estado }}</span>
                        @endif
                    </td>
                    <td>{{ $cotizacion->usuario->name }}</td>
                    <td>{!! $cotizacion->especialista->name !!}</td>
                    <td>{!! $cotizacion->modalidad->modalidad !!}</td>
                    <td>{{ $cotizacion->peso }}</td>
                    <td>{{ $cotizacion->volumen }}</td>
                    <td>{{ $cotizacion->direccion }}</td>
                    <td>{{ $cotizacion->total }}</td>
                    <td>
                        <a class="" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bars"></i>
                        </a>
                        <ul class="dropdown-menu ">
                            <li>
                                @include('admin.cotizaciones.delete')
                            </li>
                            <li>
                                <a href="{{ route('admin.especialistas.edit', $cotizacion->id) }}"
                                    class="dropdown-item   text-primary " title="Details">
                                    <i class="fa fa-lg fa-fw fa-eye"></i> Detalles
                                </a>
                            </li>
                            <li>
                                @if ($cotizacion->modalidad->id == 4)
                                    <a href="{{ route('edit.aerea', $cotizacion->id) }}"
                                        class="dropdown-item   text-warning " title="Details">
                                        <i class="fa-solid fa-circle"></i> Formulario
                                    </a>
                                @else
                                    <a href="{{ route('editar.paso1', $cotizacion->id) }}"
                                        class="dropdown-item   text-warning " title="Details">
                                        <i class="fa-solid fa-circle"></i> Inf. cotizacion
                                    </a>
                                @endif
                            </li>
                            <li>
                                <a href="{{ route('editar.paso2', $cotizacion->id) }}"
                                    class="dropdown-item   text-warning " title="Details">
                                    <i class="fa-solid fa-circle"></i> Reg. provedores
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('ticket.pdf', $cotizacion->id) }}" class="dropdown-item   text-info "
                                    title="Details">
                                    <i class="fa-solid fa-ticket"></i> Ticket
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cotizacion.pdf', $cotizacion->id) }}"
                                    class="dropdown-item   text-success " title="Details">
                                    <i class="fa-solid fa-file-pdf"></i> Cotizacion
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('validacion.print', $cotizacion->id) }}"
                                    class="dropdown-item   text-success " title="Details">
                                    <i class="fa-solid fa-circle"></i> Calcular imp.
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
