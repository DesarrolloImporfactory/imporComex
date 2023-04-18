<div>
    <div class="modal fade" id="createTarifa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Crear Tarifa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tarifa.create') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">M3</label>
                            <input type="text" class="form-control" name="m3" value="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">VXCBM</label>
                            <input type="text" class="form-control" name="vxcbm" value="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">TCBM</label>
                            <input type="text" class="form-control" name="tcbm" value="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Valor min.</label>
                            <input type="number" step="any" class="form-control" name="valor_min" value="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Valor max.</label>
                            <input type="number" step="any" class="form-control" name="valor_max" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
