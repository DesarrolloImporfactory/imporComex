<x-adminlte-modal id="modalCustom" title="Agregar Impuesto" size="sm" theme="dark" icon="fas fa-bolt" v-centered
    static-backdrop scrollable>
    <div>
        <form action="{{ route('admin.impuestos.store') }}" method="post" id="form">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre del impuesto: </label>
                <input type="text" name="nombre" class="form-control">
            </div>
            <div class="form-group">
                <label for="nombre">Signo del impuesto: </label>
                <input type="text" name="signo" class="form-control">
            </div>
            <div class="form-check form-switch">
                <input name="estado" data-onstyle="success" class="form-check-input" type="checkbox" role="switch"
                    id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault">Estado del impuesto</label>
            </div>
            <div class="form-group">
                <label for="nombre">Valor del impuesto: </label>
                <input type="text" name="valor" class="form-control">
            </div>
            <button class="btn btn-dark" type="submit" form="form">Crear</button>
            <x-adminlte-button class="btn btn-secondary" data-dismiss="modal" label="Close" />
        </form>

    </div>

</x-adminlte-modal>
