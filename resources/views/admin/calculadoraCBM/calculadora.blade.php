<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Calculadora de Metros Cubicos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-md-9">
                        <form id="form" class="calculadora">
                            <div class="input-group">

                                <div class="form-floating ">
                                    <input type="number" min="0"  class="form-control" id="cantidad" name="cantidad"
                                        placeholder="name@example.com">
                                    <label for="floatingInput">Cantidad</label>
                                </div>
                                <div class="form-floating ">
                                    <input type="number" min="0"  class="form-control" id="longitud" name="longitud"
                                        placeholder="name@example.com">
                                    <label for="floatingInput">Longitud</label>
                                </div>
                                <div class="form-floating ">
                                    <input type="number" min="0"  class="form-control" id="anchura" name="anchura"
                                        placeholder="name@example.com">
                                    <label for="floatingInput">Ancho</label>
                                </div>
                                <div class="form-floating ">
                                    <input type="number" min="0" class="form-control" id="altura" name="altura"
                                        placeholder="name@example.com">
                                    <label for="floatingInput">Altura</label>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating " >
                            <input type="text" class="form-control" id="total" disabled style="color: red">
                            <label for="floatingInput">Volumen Total</label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" form="form" class="btn btn-primary">Calcular</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('.calculadora').submit(function(e) {
        e.preventDefault();

        // -----------------------------
        let cantidad = $("#cantidad").val();
        let longitud = $("#longitud").val();
        let anchura = $("#anchura").val();
        let altura = $("#altura").val();


        if (cantidad<=0 || longitud<=0 || anchura<=0 || altura<=0 ) {
            
            document.getElementById('total').value = "Revisar los campos";
        } else {
            let result = (longitud * anchura * altura) / 1000000;
            let total = result*cantidad;
            document.getElementById('total').value = total;
            document.getElementById('volumen').value = total;
        }


        // ----------------------------
    });
</script>
