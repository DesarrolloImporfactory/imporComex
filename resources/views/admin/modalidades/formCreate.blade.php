<div>
    <div class="modal fade " id="crearModalidad" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Registrar Modalidad</h3>
                    </div>
                    <form action="{{ url('/admin/modalidades') }}" method="post" id="formulario">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre de la Modalidad</label>
                                <input type="hidden" name="tipo" id="" value="mo">
                                <input type="text" class="form-control" id="modalidad" name="modalidad"
                                    placeholder="Modalidad">
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
