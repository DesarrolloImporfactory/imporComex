<x-adminlte-card title="Gestionar cotizaciones asignadas" theme="dark" icon="fa-solid fa-handshake-angle">
    <x-table>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">ESTADO</th>
                <th scope="col">CLIENTE</th>
                <th scope="col">EXPERTO</th>
                {{-- <th scope="col">Pais</th> --}}
                <th scope="col">TIPO</th>
                {{-- <th scope="col">Origen</th> --}}
                <th scope="col">DIR. ENTREGA</th>
                <th scope="col">FLETE</th>
                <th scope="col">LOGISTICA</th>
                <th scope="col">TOTAL</th>
                <th scope="col">OP</th>

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
                    <td>{{ $cotizacion->ciudad->canton ?? $cotizacion->tarifa_id }}/{{ $cotizacion->direccion }}</td>
                    <td>{{ $cotizacion->flete_maritimo }}</td>
                    <td>{{ $cotizacion->total_logistica }}</td>
                    <td>{{ $cotizacion->total }}</td>
                    <td>
                        <a class="" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bars"></i>
                        </a>
                        <ul class="dropdown-menu ">
                            <li>
                                <a class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#modalContenedor{{ $cotizacion->id }}"
                                    title="{{ $cotizacion->id }}"><i class="fa-solid fa-repeat"></i> Editar</a>
                                </a>

                            </li>
                            <li>
                                <a href="{{ route('admin.especialistas.edit', $cotizacion->id) }}"
                                    class="dropdown-item" title="Details">
                                    <i class="fa-brands fa-stack-overflow"></i>  Gestionar
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('editar.paso1', $cotizacion->id) }}" class="dropdown-item"
                                    title="Details">
                                    <i class="fa-solid fa-circle"></i> Inf. cotizacion
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.colombia.edit', $cotizacion->id) }}" class="dropdown-item"
                                    title="Details">
                                    <i class="fa-solid fa-circle"></i> Reg. provedores
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('ticket.pdf', $cotizacion->id) }}" class="dropdown-item"
                                    title="Details">
                                    <i class="fa-solid fa-ticket"></i> Ticket
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cotizacion.pdf', $cotizacion->id) }}" class="dropdown-item"
                                    title="Details">
                                    <i class="fa-solid fa-file-pdf"></i> Cotizacion
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
