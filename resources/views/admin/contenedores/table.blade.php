@php
    $heads3 = ['id', 'Nombre', 'Estado', 'Fecha salida', 'Fecha llegada', 'Tipo', 'Latitud', 'Longitud', 'cotizaciones', 'Acciones'];
    
@endphp

<x-adminlte-card title="Gestion de Contenedores" theme="dark" icon="fa-brands fa-docker">
    <x-adminlte-datatable :heads="$heads3" head-theme="" id="table3">

        @foreach ($consulta as $contenedor)
            <tr>
                <td>{!! $contenedor->id !!}</td>
                <td>{!! $contenedor->contenedor !!}</td>
                <td>{!! $contenedor->name !!}</td>
                <td>{!! $contenedor->salida !!}</td>
                <td>{!! $contenedor->llegada !!}</td>
                <td>{!! $contenedor->tipo !!}</td>
                <td>{!! $contenedor->latitud !!}</td>
                <td>{!! $contenedor->longitud !!}</td>
                <td>{!! $contenedor->total !!}</td>
                <td>
                    <div class="btn-group">

                        <a class="btn btn-xs btn-default text-primary mx-1 shadow" href=" " data-bs-toggle="modal"
                            data-bs-target="#modalContenedor{{ $contenedor->id }}" title="{{ $contenedor->id }}">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </a>

                        @include('admin.contenedores.delete')

                    </div>

                </td>
            </tr>
            @include('admin.contenedores.edit')
        @endforeach

    </x-adminlte-datatable>
</x-adminlte-card>
