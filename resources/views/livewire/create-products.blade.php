<div>
    <!-- Button trigger modal -->
    <button wire:click.prevent="$emitTo('create-products','modal')" type="button" class="btn btn-primary">
        Launch demo modal
    </button>

   

    <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save" >
                        <label for="">Nombre</label>
                        <input type="text" wire:model.defer="nombre" id="nombre" class="form-control">
                        @error('nombre') <span class="error">{{ $message }}</span> @enderror
                        <label for="">Precio</label>
                        <input type="text" wire:model.defer="precio" class="form-control" id="precio">
                        @error('precio') <span class="error">{{ $message }}</span> @enderror
                        <label for="">Cantidad</label>
                        <input type="text" wire:model.defer="cantidad" class="form-control">
                        @error('cantidad') <span class="error">{{ $message }}</span> @enderror
                        <label for="">Categoria</label>
                        <input type="text" wire:model.defer="categoria_id" class="form-control">
                        @error('categoria_id') <span class="error">{{ $message }}</span> @enderror
                     
                        <button type="submit" class="btn btn-danger">Save Contact</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

</div>

<script>
    window.addEventListener('show-form', event => {
        $('#myModal').modal('show');
    });
    
    
</script>

