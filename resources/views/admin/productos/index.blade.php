<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mt-2" id="abrir" data-bs-toggle="modal" data-bs-target="#modalProducto">
    Agregar producto
</button>
<!-- Modal -->
<div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="formProducto">
                @csrf
                <div class="modal-body formulario">
                    <div id="validaciones">
                        <ul id="erroresProducto">

                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="">Nombre del producto: </label>
                        <input type="text" class="form-control" name="nombreInsumo" id="nombreInsumo" placeholder="Nombre del producto">
                    </div>
                    <div class="form-group">
                        <label for="">Porcentaje: </label>
                        <input type="number" min="0" class="form-control" id="porcentajeInsumo" name="porcentajeInsumo" placeholder="Valor porcentual">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="crearProducto">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        productos();
        function productos(){
            $("#insumos").append(`<option>Seleccione lo que esta buscando...</option>`);
            $.ajax({
                type: "GET",
                url: "{{ route('admin.colombia.index') }}",
                dataType: "json",
                success: function (response) {
                    $.each(response.insumos, function (key, insumo) { 
                         $("#insumos").append(`<option value="${insumo.id}" porcentaje="${insumo.porcentaje}">${insumo.nombre}</option>`);
                    });
                }
            });
        }
        $(document).on("click", "#abrir", function(e) {
            e.preventDefault();
            $("#validaciones").removeClass('alert alert-danger');
            $("#erroresProducto").html("");
            $('.formulario').find('input').val("");
            $("#crearProducto").text("Crear");
        });
        $("#formProducto").submit(function(e) {
            e.preventDefault();
            // $("#validaciones").removeClass('alert alert-danger');
            // $("#erroresProducto").html("");
            var data = $("#formProducto").serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.save.producto') }}",
                data: data,
                dataType: "json",
                success: function (response) {
                    if(response.status == 400){
                        $("#erroresProducto").html("");
                        $("#validaciones").addClass('alert alert-danger');
                        $.each(response.message, function (key, error) { 
                             $("#erroresProducto").append(`
                                <li>${error}</li>
                             `);
                        });
                        $("#crearProducto").text("Volver a intentar");
                    }else{
                        $("#crearProducto").text("Agregando....");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $(".formulario").find('input').val("");
                        $("#modalProducto").modal('hide');
                        $("#insumos").html("");
                        $('#exampleModal').find('input').val("");
                        productos();
                    }
                }
            });
        });
    });
</script>
