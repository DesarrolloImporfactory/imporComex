<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTermino">
    Crear producto
</button>
<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createTermino" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent='create' action="">
                <div class="modal-body">
                    <div class="form-group">
                        <p>Nombre del producto:</p>
                        <input type="text" wire:model='name' class="form-control">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p>Valor porcentual:</p>
                        <input type="text" wire:model='porcentaje' class="form-control">
                        @error('porcentaje')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <p>Cliente:</p>
                        <div wire:ignore class="mt-2 mr-2">
                            <select name="" class="my-select" data-width="100%" id="usuario"
                                data-live-search="true" title="Seleccionar.." data-style="btn-primary">
                                @foreach ($clientes as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('usuario')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <p for="">Impu. adicional: </p>
                                <input type="text" wire:change='calcular' class="form-control form-control-sm"
                                    wire:model="adicional" id="adicional" name="adicional">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <p for="">Variable: </p>
                            <select name="variable" wire:change='calcular' wire:model="variable"
                                class="form-select form-control-sm">
                                <option value="unidad">Unidad</option>
                                <option value="porcentual">Porcentual</option>
                                <option value="kilogramos">Kilogramos</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <p for="">Valor: </p>
                                <input type="text" class="form-control form-control-sm" wire:change='calcular'
                                    wire:model="valor_adicional" id="valor_adicional">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <p for="">Resultado: </p>
                            <input type="text" readonly class="form-control form-control-sm" wire:model='resultado'
                                name="total">
                        </div>
                        @error('adicional')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('variable')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <p>Alto:</p>
                            <input type="text" wire:change='calcularVolumen' class="form-control form-control-sm"
                                wire:model='alto' id="edit_alto">
                            @error('alto')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <p>Ancho:</p>
                            <input type="text" wire:change='calcularVolumen' class="form-control form-control-sm"
                                wire:model='ancho' id="edit_ancho">
                            @error('ancho')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <p>Largo:</p>
                            <input type="text" wire:change='calcularVolumen' class="form-control form-control-sm"
                                wire:model='largo' id="edit_largo">
                            @error('largo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <p>Volumen:</p>
                            <input type="text" readonly class="form-control form-control-sm" wire:model='volumen'>
                        </div>
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
@push('js')
    <script>
        $('#edit_largo,#edit_ancho,#edit_alto').on('input', function() {
        // Remover caracteres no permitidos y sustituir comas por puntos
        this.value = this.value.replace(/[^0-9.]/g, '').replace(/,/g, '.');

        // Limitar a un solo punto decimal
        var countDots = (this.value.match(/\./g) || []).length;
        if (countDots > 1) {
            this.value = this.value.replace(/\./g, '');
        }

        // Limitar a dos decimales
        var decimalIndex = this.value.indexOf('.');
        if (decimalIndex !== -1 && this.value.length - decimalIndex > 3) {
            this.value = this.value.slice(0, decimalIndex + 3);
        }
    });
    </script>
@endpush
