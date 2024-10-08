<div>
    <div class="modal fade" id="example{{ $tarifa->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar tarifa: {{ $tarifa->m3 }} </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/tarifa/' . $tarifa->id) }}" method="post" id="formulario">
                    {{ method_field('PATCH') }}
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">M3</label>
                            <input type="text" class="form-control" name="m3"
                                value="{{ isset($tarifa->m3) ? $tarifa->m3 : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">VXCBM</label>
                            <input type="text" class="form-control" name="vxcbm"
                                value="{{ isset($tarifa->vxcbm) ? $tarifa->vxcbm : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">TCBM</label>
                            <input type="text" class="form-control" name="tcbm"
                                value="{{ isset($tarifa->tcbm) ? $tarifa->tcbm : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Valor min.</label>
                            <input type="number" step="any" class="form-control" name="valor_min"
                                value="{{ isset($tarifa->valor_min) ? $tarifa->valor_min : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Valor max.</label>
                            <input type="number" step="any" class="form-control" name="valor_max"
                                value="{{ isset($tarifa->valor_max) ? $tarifa->valor_max : '' }}">
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
