@php
    $heads3 = ['ID', 'Nombre', 'Acciones'];
    
@endphp
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado de Estados</h3>
        <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#crearEstado">
            Agregar Estado
        </button>
        @include('admin.modalidades.estados.create')
    </div>
    <div class="card-body">
        <x-adminlte-datatable :heads="$heads3" head-theme="dark" id="table4">

            @foreach ($estados as $estado)
                <tr>
                    <th scope="row">{!! $estado->id !!}</th>
                    <td>{!! $estado->name !!}</td>
                    
                    
                    <td>
                        <a class="" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bars"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item " href=" " data-bs-toggle="modal"
                                    data-bs-target="#modalEstado{{ $estado->id }}"><i
                                        class="bi bi-pencil-square"></i> Editar
                                </a>
                            </li>
                            <li>
                                @include('admin.modalidades.estados.delete')
                            </li>

                        </ul>
                    </td>
                </tr>
                @include('admin.modalidades.estados.edit')
            @endforeach

        </x-adminlte-datatable>

    </div>
</div>
