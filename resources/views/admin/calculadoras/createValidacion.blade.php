<div class="card">
    <div class="card-body">
        <div class="row formularios">

            <div class="col-md-4">
                <div class="form-group">
                    <label for="">¿Es inflamable?</label>
                    <x-adminlte-select2 name="inflamable" id="inflamable" onchange="accion3()">
                        <option value="">Selecciona una opción....</option>
                        <option value="si"{{ old('inflamable') == 'si' ? 'selected' : '' }}>Si</option>
                        <option value="no"{{ old('inflamable') == 'no' ? 'selected' : '' }}>No</option>
                    </x-adminlte-select2>

                </div>

            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">¿Tiene liquidos?</label>
                    <x-adminlte-select2 name="liquidos" id="liquidos" onchange="accion1()" class="liquidos">
                        <option value="">Selecciona una opción....</option>
                        <option value="si"{{ old('liquidos') == 'si' ? 'selected' : '' }}>Si</option>
                        <option value="no"{{ old('liquidos') == 'no' ? 'selected' : '' }}>No</option>
                    </x-adminlte-select2>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="">Cant. de proveedores:</label>
                    <x-adminlte-select2 name="proveedores" id="numero" onchange="ejecutar()" class="form-control">
                        <option value="1"{{ old('proveedores') == '1' ? 'selected' : '' }}>1</option>
                        <option value="2"{{ old('proveedores') == '2' ? 'selected' : '' }}>2</option>
                        <option value="3"{{ old('proveedores') == '3' ? 'selected' : '' }}>3</option>
                        <option value="4"{{ old('proveedores') == '4' ? 'selected' : '' }}>4</option>
                        <option value="5"{{ old('proveedores') == '5' ? 'selected' : '' }}>5</option>
                    </x-adminlte-select2>
                </div>
            </div>

        </div>
        <div class="row">
            {{-- div para los inputs dinamicos --}}
            <div class="newData"></div>
            <div class="datos">
                <div id="newRow" class="form-row">
                    <div class="col-md-6">
                        <label style="color:red">Nombre del Proveedor 1:</label>
                        <input type="text" name="nombre_pro1" class="form-control"
                            placeholder="Ingrese el nombre del proveedor" value="">
                    </div>
                    <div class="col-md-6">
                        <label style="color:red">Cantidad de cartones 1:</label>
                        <input type="number" name="total_cartones1" min="1" class="form-control"
                            placeholder="Cantidad">
                    </div>
                </div>
                <div id="newRow" class="form-row">
                    <div class="col-md-6">
                        <label style="color:red">Enlace del producto 1:</label>
                        <input type="text" name="enlace1
                        " class="form-control"
                            placeholder="www.ejemplo.com" required>
                    </div>
                    <div class="col-md-6">
                        <label style="color:red">Contacto del proveedor :</label>
                        <input type="text" name="contacto1
                        " class="form-control"
                            placeholder="telefono, email, direccion">
                    </div>
                </div>
                <div id="newRow" class="form-row">
                    <div class="col-md-6">
                        <label style="color:red">Foto del producto 1:</label>
                        <input type="file" name="foto1" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label style="color:red">Subir factura 1:</label>
                        <input type="file" name="factura1" class="form-control">
                        <input type="hidden" name="estado[]" value="1" class="form-control">
                    </div>
                </div>
            </div>
            {{-- div para los inputs dinamicos --}}
        </div>
    </div>
</div>

<script type="text/javascript">
    function accion1(valor) {

        valor = $("#liquidos").val();

        if (valor == 'si') {
            Swal.fire({
                title: '<strong><u>lo sentimos mucho</u></strong>',
                icon: 'error',
                html: 'En carga GRUPAL no se puede cargar este tipo de producto. Dirigete al siguiente enlace para realizar una cotizacion invidual:</b>  ' +
                    '<a href="{{ route('admin.individual.create') }}" >Cotizacion invididual</a> ',
                showCloseButton: false,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> OK!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down'
            })
        }

    }

    function accion3() {

        let valor = $("#inflamable").val();

        if (valor == 'si') {
            Swal.fire({
                title: '<strong><u>lo sentimos mucho</u></strong>',
                icon: 'error',
                html: 'En carga GRUPAL no se puede cargar este tipo de producto. Dirigete al siguiente enlace para realizar una cotizacion invidual:</b>  ' +
                    '<a href="{{ route('admin.individual.create') }}" >Cotizacion invididual</a> ',
                showCloseButton: false,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> OK!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down'
            })
        }
    }

    function ejecutar(valor) {
        //codigo para vaciar el div antes de ejecutar
        $(".datos").remove();
        $(".newData").empty();
        //codigo para vaciar el div antes de ejecutar
        var i = 1;
        valor = $("#numero").val();
        var stop = valor;

        for (let step = 0; step < stop; step++) {

            $('.newData').append(
                '<div id="newRow' + i + '" class="form-row">' +
                '<div class="col-md-6">' +
                '<label style="color:red">Nombre del Proveedor ' + i + ':</label>' +
                '<input  type="text" name="nombre_pro' + i +
                '"  class="form-control"  placeholder="Ingrese el nombre del proveedor" value="{{ old('nombre_pro') }}">' +
                '</div>' +
                '<div class="col-md-6">' +
                '<label style="color:red">Cantidad de cartones ' + i + ':</label>' +
                '<input  type="number" name="total_cartones' + i +
                '" min="1"  class="form-control"  placeholder="Cantidad">' +
                '</div>' +
                '</div>' +
                '<div id="newRow' + i + '" class="form-row">' +
                '<div class="col-md-6">' +
                '<label style="color:red">Enlace del producto ' + i + ':</label>' +
                '<input  type="text" name="enlace' + i +
                '"  class="form-control"  placeholder="www.ejemplo.com" required>' +
                '</div>' +
                '<div class="col-md-6">' +
                '<label style="color:red">Contacto del proveedor ' + i + ':</label>' +
                '<input  type="text" name="contacto' + i +
                '"  class="form-control"  placeholder="telefono, email, direccion">' +
                '</div>' +
                '</div>' +
                '<div id="newRow' + i + '" class="form-row">' +
                '<div class="col-md-6">' +
                '<label style="color:red">Foto del producto ' + i + ':</label>' +
                '<input type="file" name="foto' + i + '"  class="form-control">' +
                '</div>' +
                '<div class="col-md-6">' +
                '<label style="color:red">Subir factura ' + i + ':</label>' +
                '<input type="file" name="factura' + i + '" class="form-control">' +
                '<input type="hidden" name="estado[]" value="' + i + '" class="form-control">' +
                '</div>' +
                '</div><br>'
            );
            i++;
        }

    }
</script>
