@php
    $heads3 = ['id','Nombre', 'Estado', 'Fecha salida', 'Fecha llegada', 'Tipo', 'Latitud', 'Longitud','cotizaciones', 'Acciones'];
    
@endphp
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado de Contenedores</h3>
        <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#crearContenedor">
            Agregar Contenedor
        </button>
        @include('admin.contenedores.create')
    </div>
    <div class="card-body">

        <x-adminlte-datatable :heads="$heads3" head-theme="dark" id="table3">

            @foreach ($consulta as $contenedor )
                <tr>
                    <td>{!! $contenedor->id!!}</td>
                    <td>{!! $contenedor->contenedor!!}</td>
                    <td>{!! $contenedor->name!!}</td>
                    <td>{!! $contenedor->salida !!}</td>
                    <td>{!! $contenedor->llegada !!}</td>
                    <td>{!! $contenedor->tipo !!}</td>
                    <td>{!! $contenedor->latitud !!}</td>
                    <td>{!! $contenedor->longitud !!}</td>
                    <td>{!! $contenedor->total!!}</td>
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
                                @include('admin.contenedores.delete')
                            </li>

                        </ul>
                    </td>
                </tr>
                @include('admin.contenedores.edit')
            @endforeach

        </x-adminlte-datatable>
    </div>
</div>
