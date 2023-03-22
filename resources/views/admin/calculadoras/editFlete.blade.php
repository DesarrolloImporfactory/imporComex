<div class="modal fade" id="editFlete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Valor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('update.flete', $cotizacion->id) }}" method="post" id="myform">
                {{ method_field('PATCH') }}
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">Valor del Flete:</label>
                        <input type="text" class="form-control" name="flete" id="flete"
                            value="{{ $cotizacion->flete_maritimo }}">
                        <input type="hidden" class="form-control" name="gastos" id="gastos"
                            value="{{ $cotizacion->gastos_origen }}">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    label.error {
        color: red;
    }

    input.error {
        border: 1px solid red;
    }
</style>
<script>
    $(document).ready(function() {
        $("#myform").validate({
            rules: {
                flete: {
                    required: true,
                    number: true
                }
            },
            messages: {
                flete: {
                    required: "Ingrese un valor",
                    number: "Solo se acepta numeros"
                }
            }
        });
    });
</script>
