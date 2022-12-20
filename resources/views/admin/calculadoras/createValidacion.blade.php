<div class="card">
    <div class="card-body">
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">

                    <label for="">¿Tiene bateria?</label>
                    <x-adminlte-select2 name="bateria">
                        <option value="">Selecciona una opción....</option>
                        <option value="{{ old('bateria') }}">{{ old('bateria') }}</option>
                        
                        <option value="si">Si</option>
                        <option value="no">No</option>
                    </x-adminlte-select2>
                </div>
                <div class="form-group">
                    <label for="">¿Es inflamable?</label>
                    <x-adminlte-select2 name="inflamable">
                        <option value="">Selecciona una opción....</option>
                        <option value="{{ old('inflamable') }}">{{ old('inflamable') }}</option>
                        
                        <option value="si">Si</option>
                        <option value="no">No</option>
                    </x-adminlte-select2>

                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">¿Tiene liquidos?</label>
                    <x-adminlte-select2 name="liquidos">
                        <option value="">Selecciona una opción....</option>
                        <option value="{{ old('liquidos') }}">{{ old('liquidos') }}</option>
                        
                        <option value="si">Si</option>
                        <option value="no">No</option>
                    </x-adminlte-select2>

                </div>
                <div class="form-group">
                    <label for="">¿Cuantos proveedores tiene?</label>
                    <x-adminlte-select2 name="proveedores" id="numero" onchange="ejecutar()" class="form-control">
                        <option value="">Selecciona una opción....</option>
                        <option value="{{ old('proveedores') }}">{{ old('proveedores') }}</option>
                        
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </x-adminlte-select2>
                    {{-- <input type="number" class="form-control add-btn " id="numero" onkeyup="ejecutar()" name="proveedores"
                        placeholder="Cantidad" value="{{ old('proveedores') }}"> --}}

                </div>

            </div>

            {{-- div para los inputs dinamicos --}}
            <div class="newData"></div>

            {{-- div para los inputs dinamicos --}}
        </div>
    </div>
</div>

<script type="text/javascript">
    function ejecutar(valor) {
        //codigo para vaciar el div antes de ejecutar
        $(".newData").empty();
        //codigo para vaciar el div antes de ejecutar
        var i = 1;
        valor = $("#numero").val();
        var stop = valor;

        for (let step = 0; step < stop; step++) {

            $('.newData').append(
                '<div id="newRow' + i + '" class="form-row">' +
                '<div class="col-md-12">' +
                '<label style="color:red">Nombre del Proveedor ' + i + ':</label>' +
                '<input  type="text" name="nombre_pro' + i +'"  class="form-control"  placeholder="Ingrese el nombre del proveedor">' +
                '</div>' +
                '</div>' +
                '<div id="newRow' + i + '" class="form-row">' +
                '<div class="col-md-12">' +
                '<label style="color:red">Enlace o contacto del proveedor ' + i + ':</label>' +
                '<input  type="text" name="enlace' + i +'"  class="form-control"  placeholder="Ingrese el contacto o enlace del proveedor">' +
                '</div>' +
                '</div>' +
                '<div id="newRow' + i + '" class="form-row">' +
                '<div class="col-md-6">' +
                '<label style="color:red">Foto del producto ' + i + '</label>' +
                '<input type="file" name="foto' + i + '"  class="form-control">' +
                '</div>' +
                '<div class="col-md-6">' +
                '<label style="color:red">Subir factura ' + i + '</label>' +
                '<input type="file" name="factura' + i + '" class="form-control">' +
                '<input type="hidden" name="estado[]" value="' + i + '" class="form-control">' +
                '</div>' +
                '</div><br>'
            );
            i++;
        }

    }
</script>
