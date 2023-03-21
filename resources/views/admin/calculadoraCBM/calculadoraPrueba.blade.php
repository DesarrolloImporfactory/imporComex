<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Calculadora de Metros Cubicos</h1>
            </div>
            <div class="modal-body">
                <div class="row formulario">
                    <div class="form-group col-3">
                        <label for="">Cartones</label>
                        <input type="number" min="0" name="" id="cartones" class="form-control">

                    </div>
                    <div class="form-group col-3">
                        <label for="">Largo</label>
                        <input type="number" min="0" name="" id="longitud" class="form-control">
                    </div>
                    <div class="form-group col-3">
                        <label for="">Ancho</label>
                        <input type="number" name="" min="0" id="ancho" class="form-control">
                    </div>
                    <div class="form-group col-3">
                        <label for="">Alto</label>
                        <input type="number" name="" min="0" id="altura" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <table class="table table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th>Cartones</th>
                                <th>Longitud</th>
                                <th>Ancho</th>
                                <th>Altura</th>
                                <th>Volumen</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="tblInsumo">
                            
                        </tbody>

                    </table>
                    
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <input style="color: red" placeholder="Volumen total"   type="button" class="form-control" name="precio" id="precio_total" readonly>
                    </div>
                    <div class="col-md-7">
                        <button type="button" class="btn btn-primary " id="bt_add">Agregar</button>
                        <button type="button" class="btn btn-secondary float-right" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#bt_add").click(function() {
            
            agregar();
        })
    })
    var cont = 0;

    function agregar() {
        
        cont++;
        var cartones = $("#cartones").val();
        var longitud = $("#longitud").val();
        var ancho = $('#ancho').val();
        var altura = $('#altura').val();
        if (cartones > 0 && longitud > 0) {
            // var total = (parseFloat(longitud*ancho*altura))/1000000;
            $('#tblInsumo').append(`
                    <tr id="tr-${cont}">
                        <td>${cartones}</td>
                        <td>${longitud}</td>
                        <td>${ancho}</td>
                        <td>${altura}</td>
                        <td>${(((parseFloat(longitud)*parseFloat(ancho)*parseFloat(altura))/1000000)*cartones).toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn btn-danger" onClick="eliminar_insumo(${cont}, ${(((parseFloat(longitud)*parseFloat(ancho)*parseFloat(altura))/1000000)*cartones).toFixed(2)})"><i class="fa-solid fa-trash"></i></button>    
                        </td>
                    </tr>
                `);
            var precio_total = $("#precio_total").val() || 0;
            $("#precio_total").val((parseFloat(precio_total) + ((parseFloat(longitud)* parseFloat(ancho)*parseFloat(altura))/1000000)*cartones).toFixed(2));
            $("#volumen").val((parseFloat(precio_total) + ((parseFloat(longitud)* parseFloat(ancho)*parseFloat(altura))/1000000)*cartones).toFixed(2));
        } else {
            alert("se debe ingresar valores validos");
        }
        $('.formulario').find('input').val("");
    }

    function eliminar_insumo(id, subTotal){
            $("#tr-"+id).remove();
            var precio_total = $("#precio_total").val() || 0;
            $("#precio_total").val((parseFloat(precio_total)- parseFloat(subTotal)).toFixed(2));
            $("#volumen").val((parseFloat(precio_total)- parseFloat(subTotal)).toFixed(2));
        }
</script>
