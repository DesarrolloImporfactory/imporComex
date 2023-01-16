<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Calculadora de Metros Cubicos</h1>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                <button class="btn add-btn btn-info">+</button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-9">
                        <form id="form" class="calculadora">
                            <div class="input-group">

                                <div class="form-floating ">
                                    <input type="number" min="0" class="form-control" id="cantidad"
                                        name="cantidad" placeholder="name@example.com">
                                    <label for="floatingInput">Cantidad</label>
                                </div>
                                <div class="form-floating ">
                                    <input type="number" min="0" class="form-control" id="longitud"
                                        name="longitud" placeholder="name@example.com">
                                    <label for="floatingInput">Longitud</label>
                                </div>
                                <div class="form-floating ">
                                    <input type="number" min="0" class="form-control" id="anchura"
                                        name="anchura" placeholder="name@example.com">
                                    <label for="floatingInput">Ancho</label>
                                </div>
                                <div class="form-floating ">
                                    <input type="number" min="0" class="form-control" id="altura"
                                        name="altura" placeholder="name@example.com">
                                    <label for="floatingInput">Altura</label>
                                </div>
                            </div><br>

                        </form>
                    </div>
                    <div class="col-md-3">

                        <div class="form-floating ">
                            <input type="text" class="form-control" id="total" disabled style="color: red">
                            <label for="floatingInput">Volumen</label>
                        </div>


                    </div>
                </div>
                <div class="newData"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" form="form" class="btn btn-primary">Calcular</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        var i = 0;
        var j = 0;
        $('.add-btn').click(function(e) {
            e.preventDefault();
            j++;
            i++;

            $('.newData').append('<div class="row" id="newRow' + i + '">' +
                '<div class="col-md-9">' +
                '<form id="forms" class="calculadora">' +
                '<div class="input-group">' +
                '<div class="form-floating ">' +
                '<input type="number" min="0"  class="form-control"  name="cantidad' + i +
                '" id="cantidad' + i + '" placeholder="name@example.com">' +
                '<label for="floatingInput">Cantidad</label>' +
                '</div>' +
                '<div class="form-floating ">' +
                '<input type="number" min="0"  class="form-control"  name="longitud' + i +
                '" id="longitud' + i + '" placeholder="name@example.com">' +
                '<label for="floatingInput">Longitud</label>' +
                '</div>' +
                '<div class="form-floating ">' +
                '<input type="number" min="0"  class="form-control" id="anchura' + i +
                '" name="anchura' + i + '" placeholder="name@example.com">' +
                '<label for="floatingInput">Ancho</label>' +
                '</div>' +
                '<div class="form-floating ">' +
                '<input type="number" min="0" class="form-control" id="altura' + i +
                '" name="altura' + i + '" placeholder="name@example.com">' +
                '<label for="floatingInput">Altura</label>' +
                '</div>' +
                '</div><br>' +
                '</form>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<div class="form-floating " >' +
                '<input type="text" class="form-control" id="total' + i + '"  disabled style="color: red">' +
                '<label for="floatingInput">Volumen Total</label>' +
                '</div>' +
                '</div>'
            );

            $('.calculadora').submit(function(e) {
                e.preventDefault();
                var k = 1;
                // let cantidad1 = $("#cantidad").val();
                // let longitud1 = $("#longitud").val();
                // let anchura1 = $("#anchura").val();
                // let altura1 = $("#altura").val();
                var contador = 0;
                for (let step = 0; step < j; step++) {
                    let cantidad = $("#cantidad" + k).val();
                    let longitud = $("#longitud" + k).val();
                    let anchura = $("#anchura" + k).val();
                    let altura = $("#altura" + k).val();



                    if (cantidad <= 0 || longitud <= 0 || anchura <= 0 || altura <= 0) {

                        document.getElementById('total' + k).value = "Revisar los campos";
                    } else {
                        let result = (longitud * anchura * altura) / 1000000;
                        let total = result * cantidad;
                        contador = contador+total;
                        let valor = document.getElementById('total').value;
                        document.getElementById('total' + k).value = total;
                        document.getElementById('volumen').value = (parseFloat(contador)+parseFloat(valor)).toFixed(2);
                    }
                    k++
                    
                }
                
                // ----------------------------
            });

        });


        $(document).on('click', '.remove-lnk', function(e) {
            e.preventDefault();
            var id = $(this).attr("id");
            $('#newRow' + id + '').remove();
        });

    });

    $('.calculadora').submit(function(e) {
        e.preventDefault();

        // -----------------------------
        let cantidad = $("#cantidad").val();
        let longitud = $("#longitud").val();
        let anchura = $("#anchura").val();
        let altura = $("#altura").val();


        if (cantidad <= 0 || longitud <= 0 || anchura <= 0 || altura <= 0) {

            document.getElementById('total').value = "Revisar los campos";
        } else {
            let result = (longitud * anchura * altura) / 1000000;
            let total = result * cantidad;
            document.getElementById('total').value = total;
            document.getElementById('volumen').value = total;
        }


        // ----------------------------
    });
</script>
