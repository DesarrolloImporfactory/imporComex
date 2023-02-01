{{-- Themed --}}
<x-adminlte-modal id="modal" title="Crear producto" size="sm" theme="teal" icon="fas fa-box" v-centered static-backdrop
    scrollable>
    <div>
        <form action="{{ route('admin.save.producto') }}" method="post" id="formProduct">
            @csrf
            <input type="hidden" name="cotizacion_id" value="{{ $cotizacion->id }}">
            <div class="row">
                <x-adminlte-input name="nombreInsumo" id="nombreInsumo" label="Nombre del producto"
                    placeholder="producto...." fgroup-class="col-md-12" disable-feedback />
            </div>
            <div class="row">
                <x-adminlte-input name="precioInsumo" id="precioInsumo" label="Precio del producto"
                    placeholder="precio...." fgroup-class="col-md-12" disable-feedback />
            </div>
            <div class="form-group">
                <label for="">Porcentaje</label>
                <input type="text" class="form-control" id="porcentajeInsumo" name="porcentajeInsumo">
            </div>
            {{-- <div class="row">
                <label for="">Categoria</label>
                <x-adminlte-select2 name="sel2Basic" id="mySelect2">
                    @foreach ($categoria as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </x-adminlte-select2>
            </div> --}}
            <div class="row">
                <x-adminlte-input name="cantidadInsumo" id="cantidadInsumo" label="Cantidad de productos"
                    placeholder="cantidad...." fgroup-class="col-md-12" disable-feedback />
            </div><br>
            
            <button class="btn btn-danger" type="submit">Crear</button>
            <x-adminlte-button class="btn btn-secondary" data-dismiss="modal" label="Close" />
        </form>

    </div>

</x-adminlte-modal>
{{-- Example button to open modal --}}
<x-adminlte-button label="Crear producto" data-toggle="modal" data-target="#modal" class="bg-success mt-3" />
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
                cantidadInsumo: "required",
                precioInsumo: "required",
                porcentajeInsumo: "required",

            },
            messages: {
                nombreInsumo: "Por favor ingresa el nombre del insumo",
                cantidadInsumo: " Por favor ingresa la cantidad de insumos ",
                precioInsumo: " Por favor ingresa el precio del insumo ",
                porcentajeInsumo: "Porfavor ingrese el porcentaje del insumo",
            },

        });
    });
</script>
