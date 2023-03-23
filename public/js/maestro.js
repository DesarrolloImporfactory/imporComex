function colocar() {
    var porcentaje = $("#insumos option:selected").attr('porcentaje');
    $("#porcentaje").val(porcentaje);
}


$(document).ready(function() {

    function icono() {
        $(".logistica").html('');
        $(".impuestos").html('');
        $(".compra").html('');
        $(".cotizacion_total").html('');
        $(".productos_total").html('');
        $(".fob_total").html('');

        var logistica = $("#logistica").val();
        if (logistica > 0) {
            $(".logistica").prepend(`
    <i class="fa-solid fa-check text-teal"></i> <label for="">Total logistica : </label>
    `);
        } else {
            $(".logistica").prepend(`
    <i class="fa-regular fa-circle-xmark text-danger"></i> <label for="">Total logistica : </label>
    `);
        }
        var impuestos = $("#impuestos").val();
        if (impuestos > 0) {
            $(".impuestos").prepend(`
    <i class="fa-solid fa-check text-teal"></i> <label for="">Total impuestos : </label>
    `);
        } else {
            $(".impuestos").prepend(`
    <i class="fa-regular fa-circle-xmark text-danger"></i> <label for="">Total impuestos : </label>
    `);
        }
        var compra = $("#compra").val();
        if (compra > 0) {
            $(".compra").prepend(`
    <i class="fa-solid fa-check text-teal"></i> <label for="">Total compra : </label>
    `);
        } else {
            $(".compra").prepend(`
    <i class="fa-regular fa-circle-xmark text-danger"></i> <label for="">Total compra : </label>
    `);
        }
        var cotizacion_total = $("#cotizacion_total").val();
        if (cotizacion_total > 0) {
            $(".cotizacion_total").prepend(`
    <i class="fa-solid fa-check text-teal"></i> <label for="">Total : </label>
    `);
        } else {
            $(".cotizacion_total").prepend(`
    <i class="fa-regular fa-circle-xmark text-danger"></i> <label for="">Total : </label>
    `);
        }
        var productos_total = $("#productos_total").val();
        if (productos_total > 0) {
            $(".productos_total").prepend(`
    <i class="fa-solid fa-check text-teal"></i> <label for="">Total productos : </label>
    `);
        } else {
            $(".productos_total").prepend(`
    <i class="fa-regular fa-circle-xmark text-danger"></i> <label for="">Total productos : </label>
    `);
        }
        var fob_total = $("#fob_total").val();
        if (fob_total > 0) {
            $(".fob_total").prepend(`
    <i class="fa-solid fa-check text-teal"></i> <label for="">Total FOB : </label>
    `);
        } else {
            $(".fob_total").prepend(`
    <i class="fa-regular fa-circle-xmark text-danger"></i> <label for="">Total FOB : </label>
    `);
        }

    }



    fetchProducts();

    function fetchProducts() {
        var $id_cotizacion = $('#cotizacion_id').val();
        $.ajax({
            type: "GET",
            url: "../../admin/relacion/" + $id_cotizacion,
            dataType: "json",
            success: function(response) {
                //console.log(response);
                $('#body').html("");
                $.each(response.productos, function(key, producto) {
                    $('#body').append(`
                <tr>
                    <td>${(producto.id)}</td>
                    <td>${producto.insumo.nombre}</td>
                    <td>${(producto.precio).toFixed(2)}</td>
                    <td>${(producto.cantidad).toFixed(2)}</td>
                    <td>${(producto.fob).toFixed(2)}</td>
                    <td>${(producto.flete).toFixed(2)}</td>
                    <td>${(producto.Impuestos).toFixed(2)}</td>
                    <td>${(producto.total).toFixed(2)}</td>
                    <td>
                        <a type="button" value="${producto.id}" id="btn-eliminar" class=" btn-sm"><i class="fa-solid fa-trash "></i></a>
                        <a type="button" value="${producto.id}" id="btn-edit" class="btn-sm"><i class="fa-solid fa-pen-to-square "></i></a>
                        <a type="button" value="${producto.id}" id="btn-ver" class="btn-sm"><i class="fa-solid fa-eye text-teal"></i></a>
                    </td>
                </tr>
             `);
                });
                $("#bodyTotal").append(`
         <tr>
                 <td><b>Total:</b></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td><b>${(response.totalFob).toFixed(2)}</b></td>
                 <td><b>${(response.totalFlete).toFixed(2)}</b></td>
                 <td><b>${(response.totalImpuestos).toFixed(2)}</b></td>
                 <td><b>${(response.totalTotal).toFixed(2)}</b></td>
                 <td></td>
             </tr>
         `);
                $("#compra").val((response.totalFob).toFixed(2));
                $("#impuestos").val((response.totalImpuestos).toFixed(2));
                $("#fob_total").val((response.totalFob).toFixed(2));
                var logistica = $("#valor").val();
                $("#logistica").val((logistica));

                $("#cotizacion_total").val((response.totalFob + response.totalImpuestos +
                    parseFloat(logistica)).toFixed(2));

                $("#productos_total").val((response.totalProducto));

                icono();
            }
        });

    }
    //funcion para editar
    $(document).on('click', '#btn-edit', function(e) {
        e.preventDefault();
        $('#errores_formEdit').html("");
        var id = $(this).attr('value');
        $('#editarModal').modal('show');
        $.ajax({
            type: "GET",
            url: "../../admin/relacion/" + id + "/edit",
            success: function(response) {
                if (response.status == 400) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    $('#relacion_id').val(response.relacion.id);
                    $('#edit_cantidad').val(response.relacion.cantidad);
                    $('#edit_precio').val(response.relacion.precio);
                    $('#edit_porcentaje').val(response.relacion.porcentaje);
                }
            }
        });
    });

    $(document).on('click', '#btn-ver', function(e) {
        e.preventDefault();
        $('#errores_formEdit').html("");
        var id = $(this).attr('value');
        $('#verModal').modal('show');
        $.ajax({
            type: "GET",
            url: "../../admin/relacion/" + id + "/edit",
            success: function(response) {
                if (response.status == 400) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    $('#edit_cif').val(response.relacion.cif);
                    $('#edit_fob').val(response.relacion.fob);
                    $('#edit_por').val(response.relacion.porcentaje);
                    $('#edit_advalorem').val(response.relacion.advalorem);
                    $('#edit_fodinfa').val(response.relacion.fodinfa);
                    $('#edit_iva').val(response.relacion.iva);
                }
            }
        });
    });

    //funcion para actualizar
    $(document).on('click', '.actualizar', function(e) {
        e.preventDefault();
        $("#bodyTotal").html("");
        $(this).text("Actualizando....");
        var relacion_id = $('#relacion_id').val();
        var datos = {
            'cantidad': $('#edit_cantidad').val(),
            'precio': $('#edit_precio').val(),
            'porcentaje': $('#edit_porcentaje').val(),
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "PUT",
            url: "../../admin/relacion/" + relacion_id,
            data: datos,
            dataType: "json",
            success: function(response) {
                if (response.status == 400) {
                    $('#errores_formEdit').html("");
                    $('#errores_formEdit').addClass('alert alert-success');
                    $.each(response.errors, function(key, err_values) {
                        $('#errores_formEdit').append(`
                    <li>${err_values}</li>
                 `);
                    });
                    $(".actualizar").text("Volver a intentar");
                } else if (response.status == 404) {
                    $('#errores_formEdit').html("");
                    Swal.fire(
                        'Buen Trabajo!',
                        response.message,
                        'success'
                    )
                } else {
                    $('#errores_formEdit').html("");
                    fetchProducts();
                    Swal.fire(
                        'Buen Trabajo!',
                        response.message,
                        'success'
                    )
                    $('#editarModal').modal('hide');
                    $('#editarModal').find('input').val("");
                    $('.actualizar').text('Actualizar valor');
                }
            }
        });
    });
    //funcion para eliminar 
    $(document).on('click', '#btn-eliminar', function(e) {
        e.preventDefault();
        $("#bodyTotal").html("");
        var relacion_id = $(this).attr('value');
        Swal.fire({
            title: 'Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Eliminalo!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "DELETE",
                    url: "../../admin/relacion/" + relacion_id,
                    success: function(response) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        fetchProducts();
                    }
                });
            }
        })
    });

    //funcion para crear registro
    $(document).on('click', '.crear', function(e) {

        e.preventDefault();

        $("#bodyTotal").html("");
        var data = {
            'insumo_id': $('#insumos').val(),
            'cantidad': $('#cantidad').val(),
            'precio': $('#precio').val(),
            'porcentaje': $('#porcentaje').val(),
            'cotizacion_id': $('#cotizacion_id').val(),
            'total_fob': $("#fob_total").val(),
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "../../admin/relacion",
            data: data,
            dataType: "json",
            success: function(response) {
                if (response.status == 400) {
                    //una forma para vaciar un div errores_formEdit
                    $("#errores").html("");
                    $('#class1').addClass('alert alert-danger');
                    $.each(response.errors, function(key, err_values) {
                        $('#errores').append(`
                    <li>${err_values}</li>
                 `);
                    });
                } else {
                    $("#class1").removeClass('alert alert-danger');
                    $("#errores").html("");
                    Swal.fire(
                        'Buen Trabajo!',
                        response.message,
                        'success'
                    )
                    fetchProducts();
                    $('#exampleModal').find('input').val("");
                    $("#insumos").val("Seleccione lo que esta buscando").trigger(
                        "change");
                }
            }
        });
    });


});