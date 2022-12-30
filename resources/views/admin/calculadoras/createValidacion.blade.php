<div class="card">
    <div class="card-body">
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">

                    <label for="">¿Tiene bateria?</label>
                    <x-adminlte-select2 name="bateria">
                        <option value="">Selecciona una opción....</option>
                        <option value="si"{{ old('bateria') == 'si' ? 'selected' : '' }}>Si</option>
                        <option value="no"{{ old('bateria') == 'no' ? 'selected' : '' }}>No</option>
                    </x-adminlte-select2>
                </div>
                <div class="form-group">
                    <label for="">¿Es inflamable?</label>
                    <x-adminlte-select2 name="inflamable">
                        <option value="">Selecciona una opción....</option>
                        <option value="si"{{ old('inflamable') == 'si' ? 'selected' : '' }}>Si</option>
                        <option value="no"{{ old('inflamable') == 'no' ? 'selected' : '' }}>No</option>
                    </x-adminlte-select2>

                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">¿Tiene liquidos?</label>
                    <x-adminlte-select2 name="liquidos">
                        <option value="">Selecciona una opción....</option>
                        <option value="si"{{ old('liquidos') == 'si' ? 'selected' : '' }}>Si</option>
                        <option value="no"{{ old('liquidos') == 'no' ? 'selected' : '' }}>No</option>
                    </x-adminlte-select2>

                </div>
                <div class="form-group">
                    <label for="">¿Cuantos proveedores tiene?</label>
                    <x-adminlte-select2 name="proveedores" id="numero" onchange="ejecutar()" class="form-control">
                        <option value="">Selecciona una opción....</option>
                        <option value="1"{{ old('proveedores') == '1' ? 'selected' : '' }}>1</option>
                        <option value="2"{{ old('proveedores') == '2' ? 'selected' : '' }}>2</option>
                        <option value="3"{{ old('proveedores') == '3' ? 'selected' : '' }}>3</option>
                        <option value="4"{{ old('proveedores') == '4' ? 'selected' : '' }}>4</option>
                        <option value="5"{{ old('proveedores') == '5' ? 'selected' : '' }}>5</option>
                    </x-adminlte-select2>
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
                '<input  type="text" name="nombre_pro' + i +'"  class="form-control"  placeholder="Ingrese el nombre del proveedor" value="{{old('nombre_pro')}}">' +
                '</div>' +
                '</div>' +
                '<div id="newRow' + i + '" class="form-row">' +
                '<div class="col-md-12">' +
                '<label style="color:red">Cantidad de cartones ' + i + ':</label>' +
                '<input  type="number" name="total_cartones' + i +'" min="1"  class="form-control"  placeholder="Cantidad">' +
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
