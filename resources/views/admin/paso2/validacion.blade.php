<div class="card">
    <div class="card-body">
        <div class="row formularios">
            <input type="hidden" value="{{ Auth::user()->id }}" name="usuarioId">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">¿Es inflamable?</label>
                    <x-adminlte-select2 name="inflamable" id="inflamable" onchange="accion3()">
                        <option value="">Selecciona una opción....</option>
                        <option value="si"{{ $validacion->inflamable == 'si' ? 'selected' : '' }}>Si</option>
                        <option value="no"{{ $validacion->inflamable == 'no' ? 'selected' : '' }}>No</option>
                    </x-adminlte-select2>

                </div>

            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">¿Tiene liquidos?</label>
                    <x-adminlte-select2 name="liquidos" id="liquidos" onchange="accion1()" class="liquidos">
                        <option value="">Selecciona una opción....</option>
                        <option value="si"{{ $validacion->liquidos == 'si' ? 'selected' : '' }}>Si</option>
                        <option value="no"{{ $validacion->liquidos == 'no' ? 'selected' : '' }}>No</option>
                    </x-adminlte-select2>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="">¿Cantidad de proveedores?</label>
                    <x-adminlte-select2 name="proveedores" id="numero" onchange="ejecutar()" class="form-control">
                        <option value="">Selecciona una opción....</option>
                        <option value="1"{{ $validacion->proveedores == '1' ? 'selected' : '' }}>1</option>
                        <option value="2"{{ $validacion->proveedores == '2' ? 'selected' : '' }}>2</option>
                        <option value="3"{{ $validacion->proveedores == '3' ? 'selected' : '' }}>3</option>
                        <option value="4"{{ $validacion->proveedores == '4' ? 'selected' : '' }}>4</option>
                        <option value="5"{{ $validacion->proveedores == '5' ? 'selected' : '' }}>5</option>
                    </x-adminlte-select2>
                </div>
            </div>

        </div>
        <div class="row">
            {{-- div para los inputs dinamicos --}}
            <div class="newData"></div>
            {{-- div para los inputs dinamicos --}}
        </div>
        <div class="row ">
            {{-- div para los inputs dinamicos --}}
            <div class="datos">
                <input type="hidden" name="condicion" value="verdad">
                @php
                    $contador = 1;
                    $contador2 = 1;
                @endphp
                <div class="col-md-6">
                    @foreach ($validaciones as $item)
                        <a href="{{ route('admin.dowload', $item->id) }}" class="btn btn-danger">Foto
                            {{ $contador++ }}</a><br><br>
                    @endforeach
                </div>
                <div class="col-md-6">
                    @foreach ($validaciones as $item)
                        <a href="{{ route('admin.dowload.archivo', $item->id) }}" class="btn btn-primary">Archivo
                            {{ $contador2++ }}</a><br><br>
                    @endforeach
                </div>
            </div>
            {{-- div para los inputs dinamicos --}}
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var cData = JSON.parse(`<?php echo $validaciones; ?>`);
        console.log(cData)
        var i = 1;
        cData.forEach(element => {
            $('.datos').append(
                '<div id="newRow' + i + '" class="form-row">' +
                '<div class="col-md-6">' +
                '<label style="color:red">Nombre del Proveedor ' + i + ':</label>' +
                '<input  type="text" name="nombre_pro' + i +
                '"  class="form-control"  placeholder="Ingrese el nombre del proveedor" value="' +
                element.nombre_pro + '">' +
                '</div>' +
                '<div class="col-md-6">' +
                '<label style="color:red">Cantidad de cartones ' + i + ':</label>' +
                '<input value="' + element.total_cartones + '" type="number" name="total_cartones' +
                i +
                '" min="1"  class="form-control"  placeholder="Cantidad">' +
                '</div>' +
                '</div>' +
                '<div id="newRow' + i + '" class="form-row">' +
                '<div class="col-md-6">' +
                '<label style="color:red">Enlace del producto ' + i + ':</label>' +
                '<input value="' + element.enlace + '" type="text" name="enlace' + i +
                '"  class="form-control"  placeholder="www.ejemplo.com" required>' +
                '</div>' +
                '<div class="col-md-6">' +
                '<label style="color:red">Contacto del proveedor ' + i + ':</label>' +
                '<input value="' + element.contacto + '" type="text" name="contacto' + i +
                '"  class="form-control"  placeholder="telefono, email, direccion">' +
                '</div>' +
                '</div>' +
                '<div id="newRow' + i + '" class="form-row">' +
                '<div class="col-md-6">' +
                '<label style="color:red">Foto del producto ' + i + '</label>' +
                '<input  type="file" name="foto' + i + '"  class="form-control">' +
                '<input  type="hidden" name="fotoOriginal' + i + '"  class="form-control" value="' +
                element.foto + '">' +
                '</div>' +
                '<div class="col-md-6">' +
                '<label style="color:red">Subir factura ' + i + '</label>' +
                '<input type="file" name="factura' + i + '" class="form-control">' +
                '<input type="hidden" name="facturaOriginal' + i +
                '" class="form-control" value="' + element.factura + '">' +
                '<input type="hidden" name="estado[]" value="' + i + '" class="form-control">' +
                '</div>' +
                '</div><br>'
            );
            i++;
        });

    });

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

        Swal.fire({
            title: 'Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
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
                        '"  class="form-control"  placeholder="Ingrese el nombre del proveedor" value="">' +
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
        })


    }
</script>
