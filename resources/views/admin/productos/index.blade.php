{{-- Themed --}}
<x-adminlte-modal id="modal" title="Agregar producto" size="sm" theme="teal" icon="fas fa-box" v-centered static-backdrop
    scrollable>
    <div>
        <form action="{{ route('admin.save.producto') }}" method="post" id="formProduct">
            @csrf
            <input type="hidden" name="cotizacion_id" value="{{ $cotizacion->id }}">
            <div class="row">
                <x-adminlte-input name="nombreInsumo" id="nombreInsumo" label="Nombre del producto"
                    placeholder="producto...." fgroup-class="col-md-12" disable-feedback />
            </div>
            <div class="form-group">
                <label for="">Porcentaje</label>
                <input type="text" class="form-control" id="porcentajeInsumo" name="porcentajeInsumo">
            </div>
            <button class="btn btn-danger" type="submit">Crear</button>
            <x-adminlte-button class="btn btn-secondary" data-dismiss="modal" label="Close" />
        </form>

    </div>

</x-adminlte-modal>
{{-- Example button to open modal --}}
<x-adminlte-button label="Agregar producto" data-toggle="modal" data-target="#modal" class="bg-warning mt-3" />
<style>
    .select2-container--open .select2-dropdown {
        z-index: 1070;
    }
    .error{
        color: red;
    }
</style>
<script>
    $(document).ready(function() {
        $('#formProduct').validate({
            rules: {
                nombreInsumo: "required",
                porcentajeInsumo: "required",

            },
            messages: {
                nombreInsumo: "Por favor ingresa el nombre del producto",
                porcentajeInsumo: "Porfavor ingrese el porcentaje del producto",
            },

        });
    });
</script>
