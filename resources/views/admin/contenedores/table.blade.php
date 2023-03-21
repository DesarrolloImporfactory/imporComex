@php
    $heads3 = ['Nombre', 'Estado', 'Cotizaciones'];
    
@endphp

<x-adminlte-card title="Cotizaciones por contenedor" theme="light" icon="fa-brands fa-docker">
    <x-adminlte-datatable :heads="$heads3" head-theme="" id="table3">

        @foreach ($consulta as $contenedor)
            <tr>
                <td>{!! $contenedor->contenedor !!}</td>
                <td>{!! $contenedor->name !!}</td>
                <td>{!! $contenedor->total !!}</td>
            </tr>
        @endforeach

    </x-adminlte-datatable>
</x-adminlte-card>
