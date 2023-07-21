<div>
    <div class="card">
        <div class="card-header">
            GESTIÓN DE TERMINOS DE NEGOCIACIÓN
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-8 col-md-8 col-lg-8 mt-2">
                    <div class="input-group">
                        <input wire:model="search" type="text" class="form-control form-control-sm"
                            placeholder="Buscar rol.">
                    </div>
                </div>
                <div class="col-4 col-md-4 col-lg-4 mt-2">

                    <button type="button" class="btn btn-primary float-right rounded-circle" data-bs-toggle="modal"
                        data-bs-target="#createTermino">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <!-- Modal -->
                    <div wire:ignore.self class="modal fade" id="createTermino" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar termino</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form wire:submit.prevent='create' action="">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <p>Nombre:</p>
                                            <input type="text" class="form-control" wire:model='name'>
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead class="thead-dark">
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
                            <th>OPCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($terminos->count())
                            @foreach ($terminos as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td style="width: 100px;">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            <button class="btn btn-xs btn-default text-primary mx-1 shadow"
                                                wire:click="show({{ $item->id }})" type="button"
                                                data-bs-toggle="modal" data-bs-target="#editTermino"><i
                                                    class="fa-solid fa-pen-to-square"></i></button>
                                            <button class="btn btn-xs btn-default text-danger mx-1 shadow"
                                                wire:click="$emit('deleteProveedor',{{ $item->id }})"
                                                type="button"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <div class="alert alert-danger">No existen registros</div>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary float-right rounded-circle" data-bs-toggle="modal"
        data-bs-target="#editTermino">
        <i class="fa-solid fa-plus"></i>
    </button>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="editTermino" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar termino</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent='create' action="">
                    <div class="modal-body">
                        <div class="form-group">
                            <p>Nombre:</p>
                            <input type="text" class="form-control" wire:model='name'>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        Livewire.on('deleteProveedor', codigo => {
            Swal.fire({
                title: 'Esta seguro de eliminar?',
                text: "Puede tener registros asociados!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminalo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('termino.admin-terminos','delete',codigo);
                }
            })
        })
    </script>
@endpush
