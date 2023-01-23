<div>
    <!-- Button trigger modal -->
    <button wire:click.prevent="addNew(true)" type="button" class="btn btn-primary">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input type="text" name="" id="" wire:model.defer="nombre"
                            class="form-control">
                            @error('nombre')
                                <span style="color: red">{{$message}}</span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Precio</label>
                        <input type="text" name="" id="" wire:model.defer="precio"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Cantidad</label>
                        <input type="text" name="" id="" wire:model.defer="cantidad"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Categoria</label>
                        <select name="" id="" class="form-control" wire:model.defer="categoria_id">
                            <option value="">Seleccione</option>
                            @foreach ($datos as $item)
                                <option value="{{$item->id}}">{{$item->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="save">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</div>
