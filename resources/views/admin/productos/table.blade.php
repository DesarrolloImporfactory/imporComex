<div class="table-responsive">
    <table class="table table-striped text-center">
        <thead class="">
            <tr>
                <th style="cursor: pointer;" wire:click="order('id')">ID
                    @if ($sort == 'id')
                        @if ($direction == 'desc')
                            <i class="fa-solid fa-arrow-up-wide-short float-right"></i>
                        @else
                            <i class="fa-solid fa-arrow-down-wide-short float-right"></i>
                        @endif
                    @else
                        <i class="fa-solid fa-sort float-right"></i>
                    @endif
                </th>
                <th style="cursor: pointer;" wire:click="order('name')">NAME
                    @if ($sort == 'name')
                        @if ($direction == 'desc')
                            <i class="fa-solid fa-arrow-up-wide-short float-right"></i>
                        @else
                            <i class="fa-solid fa-arrow-down-wide-short float-right"></i>
                        @endif
                    @else
                        <i class="fa-solid fa-sort float-right"></i>
                    @endif
                </th>
                <th>PORCENTAJE</th>
                <th>CLIENTE</th>
                <th>ADICIONAL</th>
                <th>VARIABLE</th>
                <th>TOTAL</th>
                <th>DIMENSIONES</th>
                <th>VOLUMEN</th>
                <th>OPTION</th>
            </tr>
        </thead>
        <tbody>
            @if ($productos->count())
                @foreach ($productos as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->porcentaje }}</td>
                        <td>{{ $item->usuario->name ?? '' }}</td>
                        <td>{{ $item->adicional ?? '' }}</td>
                        <td>{{ $item->variable ?? '' }}</td>
                        <td>{{ $item->total ?? '' }}</td>
                        <td>
                            @if ($item->largo)
                                {{ $item->largo . '/' . $item->ancho . '/' . $item->alto }}
                            @endif
                        </td>
                        <td>{{ $item->volumen ?? '' }}</td>
                        <td style="width: 100px;">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button class="btn btn-xs btn-default text-primary mx-1 shadow"
                                    wire:click="show({{ $item->id }})" type="button" data-bs-toggle="modal"
                                    data-bs-target="#editTermino"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button class="btn btn-xs btn-default text-danger mx-1 shadow"
                                    wire:click="$emit('deleteProducto',{{ $item->id }})" type="button"><i
                                        class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <div class="alert alert-danger">No existe coincidencias...</div>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@push('js')
    <script>
        Livewire.on('deleteProducto', idProducto => {
            Swal.fire({
                title: 'Esta seguro de eliminar?',
                text: "No habra forma de revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminalo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('productos.admin-productos', 'delete', idProducto);
                }
            })
        })
    </script>
@endpush
