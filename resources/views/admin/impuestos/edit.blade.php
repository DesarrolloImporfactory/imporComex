<x-adminlte-modal id="modal{{ $item->id }}" title="Editar Impuesto {{ $item->id }}" theme="dark"
    icon="fas fa-bolt" size='sm'>
    <form action="{{ route('admin.impuestos.update', $item->id) }}" method="post" id="form1">
        {{ method_field('PATCH') }}
        @csrf
        <div>

            <div class="form-group">
                <label for="nombre">Nombre del impuesto: </label>
                <input type="text" name="nombre" class="form-control" value="{{ $item->nombre }}">
            </div>
            <div class="form-group">
                <label for="nombre">Signo del impuesto: </label>
                <input type="text" name="signo" class="form-control" value="{{ $item->signo }}">
            </div>

            <div class="form-check form-switch">
                <input name="estado" data-id="{{ $item->estado }}" data-onstyle="success" class="form-check-input"
                    type="checkbox" role="switch" id="flexSwitchCheckDefault" {{ $item->estado ? 'checked' : '' }}>
                <label class="form-check-label" for="flexSwitchCheckDefault">Estado del Impuesto</label>
            </div>

            <div class="form-group">
                <label for="nombre">Valor del impuesto: </label>
                <input type="text" name="valor" class="form-control" value="{{ $item->valor }}">
            </div>

        </div>
        <button class="btn btn-dark" type="submit" >Editar</button>
        <x-adminlte-button class="btn btn-secondary" data-dismiss="modal" label="Close" />
    </form>

</x-adminlte-modal>
