<div class="modal fade" id="editGasto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Valor LCL</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('update.costo.lcl', $cotizacion->id) }}" method="post" id="formlcl">
                {{ method_field('PATCH') }}
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <p for="">Valor del Flete:</p>
                        <input type="text" class="form-control" name="flete" id="flete"
                            value="{{ $cotizacion->flete }}">
                    </div>
                    <div class="form-group">
                        <p for="">Agente Aduana:</p>
                        <input type="text" class="form-control" name="aduana" id="aduana"
                            value="{{ $cotizacion->aduana }}">
                    </div>
                    <div class="form-group">
                        <p for="">Bodegaje:</p>
                        <input type="text" class="form-control" name="bodegaje" id="bodegaje"
                            value="{{ $cotizacion->bodegaje }}">
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
        $("#formlcl").validate({
            rules: {
                flete: {
                    required: true,
                    number: true
                },
                aduana: {
                    required: true,
                    number: true
                },
                bodegaje: {
                    required: true,
                    number: true
                }
            },
            messages: {
                flete: {
                    required: "Ingrese un valor",
                    number: "Solo se acepta numeros"
                },
                aduana: {
                    required: "Ingrese un valor",
                    number: "Solo se acepta numeros"
                },
                bodegaje: {
                    required: "Ingrese un valor",
                    number: "Solo se acepta numeros"
                }
            }
        });
    });
</script>
