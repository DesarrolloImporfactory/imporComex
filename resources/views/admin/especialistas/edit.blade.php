<div>
    <div class="modal fade" id="modalContenedor{{ $cotizacion->id }}" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Editar Contenedor</h3>
                    </div>
                    <form action="{{ route('admin.especialistas.update', $cotizacion->id) }}" method="post">
                        {{ method_field('PATCH') }}
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Seleccionar estado</label>
                                <select name="estado" class="form-control">
                                    <option value="{{ $cotizacion->estado }}">{{ $cotizacion->estado }}</option>
                                    <option value="aprobado">Aprobado</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="finalizado">Finalizado</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
