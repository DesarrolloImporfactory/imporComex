<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">TARIFA POR CIUDAD</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="" id="alert" role="alert">
                    <ul id="errores">

                    </ul>
                </div>
                <form action="" id="formEdit">
                    @csrf
                    <div class="form-group">
                        <p>Provincia</p>
                        <input type="text" class="form-control" id="provincia" name="provincia">
                        <input type="hidden" class="form-control" id="id" name="id">
                    </div>
                    <div class="form-group">
                        <p>Canton</p>
                        <input type="text" class="form-control" id="canton" name="canton">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <p>Tarifa</p>
                            <input type="text" class="form-control" id="tarifa" name="tarifa">
                        </div>
                        <div class="form-group col-md-6">
                            <p>Kilo adicional</p>
                            <input type="text" class="form-control" id="kilo" name="kilo">
                        </div>
                    </div>
                    <div class="form-group">
                        <p>Tipo de trayecto</p>
                        <x-adminlte-select2 name="trayecto" id="trayecto" enable-old-suport>
                            <option value="">Seleccione una opcion.....</option>
                            <option value="PRINCIPAL">1. PRINCIPAL</option>
                            <option value="SECUNDARIO">2. SECUNDARIO</option>
                            <option value="ESPECIAL">3. ESPECIAL</option>
                        </x-adminlte-select2>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <p>Tiemp. Guayaquil</p>
                            <input type="text" class="form-control" id="tiemp_guayaquil" name="tiemp_guayaquil">
                        </div>
                        <div class="form-group col-md-6">
                            <p>Tiemp. Quito</p>
                            <input type="text" class="form-control" id="tiemp_quito" name="tiemp_quito">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" form="formEdit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>