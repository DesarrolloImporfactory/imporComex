<div>
    <button class="float-end btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">new product</button>
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" wire:submit.prevent='create'>
                    <div class="modal-body">
                        <div class="form-group">
                            <p>Nombre del producto</p>
                            <input type="text" class="form-control" wire:model='nombre_producto'>
                            @error('nombre_producto')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <p>Porcentaje</p>
                            <input type="text" class="form-control" wire:model='valor_porcentual'>
                            @error('valor_porcentual')
                                <span class="text-danger">{{$message}}</span>
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
