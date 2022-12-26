@php
    $heads3 = ['ID', 'Nombre', 'Estado', 'Fecha salida', 'Fecha llegada', 'Tipo', 'Latitud', 'Longitud', 'Acciones'];
    
@endphp
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado de Contenedores</h3>
        <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#crearContenedor">
            Agregar Contenedor
        </button>
        @include('admin.modalidades.contenedores.create')
    </div>
    <div class="card-body">
        <x-adminlte-datatable :heads="$heads3" head-theme="dark" id="table3">

            @foreach ($contenedores as $contenedor)
                <tr>
                    <th scope="row">{!! $contenedor->id !!}</th>
                    <td>{!! $contenedor->name !!}</td>
                    <td>{!! $contenedor->estado->name!!}</td>
                    <td>{!! $contenedor->salida !!}</td>
                    <td>{!! $contenedor->llegada !!}</td>
                    <td>{!! $contenedor->tipo !!}</td>
                    <td>{!! $contenedor->latitud !!}</td>
                    <td>{!! $contenedor->longitud !!}</td>
                    <td>
                        <a class="" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bars"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item " href=" " data-bs-toggle="modal"
                                    data-bs-target="#modalContenedor{{ $contenedor->id }}"><i
                                        class="bi bi-pencil-square"></i> Editar
                                </a>
                            </li>
                            <li>
                                @include('admin.modalidades.contenedores.delete')
                            </li>

                        </ul>
                    </td>
                </tr>
                @include('admin.modalidades.contenedores.edit')
            @endforeach

        </x-adminlte-datatable>

    </div>
</div>
