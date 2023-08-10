<div>
    @section('title', 'Productos')
     @include('cliente.productos.edit')
    <div class="content-header">
        <div class="card">
            <div class="card-header">
                <b>MIS PRODUCTOS</b>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="d-flex">
                        <div wire:ignore class="mt-2 mr-2">
                            <select name="" class="my-select" data-width="100%" id="paginate" title="paginar.."
                                data-style="btn-primary">
                                <option value="5">5 por página</option>
                                <option value="10">10 por página</option>
                                <option value="15">15 por página</option>
                            </select>
                        </div>
                        <div class="mt-2 flex-grow-1">
                            <div class="input-group">
                                <input wire:model="search" type="text" class="form-control "
                                    placeholder="Buscar.........">
                            </div>
                        </div>
                        <div class="mt-2 ml-3">
                        </div>
                        <div class="mt-2 ml-3">
                        </div>
                        <div class="mt-2 ml-3 ">
                            @include('cliente.productos.create')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <div class="table-responsive">
                                @include('cliente.productos.table')
                                <div>
                                    {{ $productos->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <script>
            $(document).ready(function() {
                $('.my-select').selectpicker();
                $('#paginate').on('change', function(e) {
                    @this.set('paginate', e.target.value);
                });
            });
            Livewire.on('limpiar', () => {
                $('#esta').val("");
                $('#estado').trigger('change');
                $('#proveedor').val("");
                $('#proveedor').trigger('change');
                $('#create').modal('show');
                $('#categoria').val("");
                $('#categoria').trigger('change');
            })
        </script>
    @stop
</div>
