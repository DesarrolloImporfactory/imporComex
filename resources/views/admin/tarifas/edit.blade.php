<div class="modal fade" id="modalEditarTarifa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">FORMULARIO DE TARIFAS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="" id="alertTarifa" role="alert">
                    <ul id="erroresTarifa">

                    </ul>
                </div>
                <form action="" id="tarifaEdit">
                    @csrf
                    <div class="form-group">
                        <p>Transporte</p>
                        <input type="text" class="form-control" id="transporte_edit" name="transporte">
                        <input type="hidden" class="form-control" id="id" name="id">
                    </div>
                    <div class="form-group">
                        <p>Origen</p>
                        <input type="text" class="form-control" id="origen_edit" name="origen">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <p>Destino</p>
                            <input type="text" class="form-control" id="destino_edit" name="destino">
                        </div>
                        <div class="form-group col-md-6">
                            <p>Peso minimo</p>
                            <input type="text" class="form-control" id="peso_min_edit" name="peso_min">
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <p>Tipo de trayecto</p>
                        <x-adminlte-select2 name="trayecto" id="trayecto" enable-old-suport>
                            <option value="">Seleccione una opcion.....</option>
                            <option value="PRINCIPAL">1. PRINCIPAL</option>
                            <option value="SECUNDARIO">2. SECUNDARIO</option>
                            <option value="ESPECIAL">3. ESPECIAL</option>
                        </x-adminlte-select2>
                    </div> --}}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <p>Peso maximo</p>
                            <input type="text" class="form-control" id="peso_max_edit" name="peso_max">
                        </div>
                        <div class="form-group col-md-6">
                            <p>Costo</p>
                            <input type="text" class="form-control" id="costo_edit" name="costo">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" form="tarifaEdit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>