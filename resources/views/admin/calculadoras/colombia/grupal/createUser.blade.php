
<x-adminlte-button data-toggle="modal" id="abrir" data-target="#example" label="Agregar Cliente" theme="warning"
                    icon="fa-solid fa-user-plus" class="float-left" />

<div class="modal fade" id="example" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header ">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registro rapido de clientes</h1>
            </div>
            <form action="{{ route('create.user.fast') }}" id="id_form">
                @csrf
                <div class="modal-body">
                    <div id="class">
                        <ul id="errores">

                        </ul>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre: </label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            value="{{ old('nombre') }}">

                    </div>
                    <div class="form-group">
                        <label for="nombre">Telefono: </label>
                        <input type="text" name="telefono" id="telefono" class="form-control"
                            value="{{ old('telefono') }}" placeholder="opcional">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Ruc: </label>
                        <input type="text" name="ruc" id="ruc" class="form-control"
                            value="{{ old('ruc') }}">
                    </div>
                    <div class="form-group ">
                        <label for="email">Email: </label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="usuario@gmail.com">

                    </div>
                    <div class="form-group">
                        <label for="nombre">Crear password temporal: </label>
                        <input type="text" name="password" id="password" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="done">Crear</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        clientes();

        function clientes() {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.clientes') }}",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $.each(response.clientes, function(key, cliente) {
                        $("#cliente").append(`
                                <option value="${cliente.id}">${cliente.name}</option>
                             `);
                    });
                }
            });
        }

        $(document).on("click", "#abrir", function(e) {
            e.preventDefault();
            $("#class").removeClass('alert alert-danger');
            $("#errores").html("");
            $('#id_form').find('input').val("");
            $("#done").text("Crear");
        });

        $("#id_form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "../admin/calculadoras",
                data: $("#id_form").serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {

                        $("#errores").html("");
                        $('#class').addClass('alert alert-danger');
                        $.each(response.messages, function(key, err_values) {
                            $("#errores").append(`
                                 <li>${err_values}</li>
                              `);
                        });
                        $("#done").text("Volver a intentar");
                    } else {
                        $("#done").text("Creando.....");
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.messages,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#id_form').find('input').val("");
                        $("#example").modal('hide');
                        clientes();
                    }
                }
            });
        });


    });
</script>
