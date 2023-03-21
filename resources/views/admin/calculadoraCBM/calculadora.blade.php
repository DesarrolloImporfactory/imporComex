<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Calculadora de Metros Cubicos</h1>
                <button type="button" onclick="agregarProducto()" class="btn btn-primary">Agregar</button><br>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <from>

                            <!-- Trigger the modal with a button -->

                            <input type="hidden" id="ListaPro" name="ListaPro" value="" required /><br>
                            <table id="TablaPro" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cartones</th>
                                        <th>Longitud</th>
                                        <th>Anchura</th>
                                        <th>Altura</th>
                                        <th>Volumen</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="ProSelected">
                                    <!--Ingreso un id al tbody-->
                                    <tr>

                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Volumen Total</td>

                                        <td>&nbsp;</td>
                                        <td><span id="total">0</span> <input class="form-control" type="hidden"
                                                id="total_final" name="total_final" value="0" readonly /></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <!--Agregue un boton en caso de desear enviar los productos para ser procesados-->

                        </from>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<script>
    function RefrescaProducto() {
        var ip = [];
        var i = 0;
        $('#guardar').attr('disabled', 'disabled'); //Deshabilito el Boton Guardar
        $('.iProduct').each(function(index, element) {
            i++;
            ip.push({
                id_pro: $(this).val()
            });
        });
        // Si la lista de Productos no es vacia Habilito el Boton Guardar
        if (i > 0) {
            $('#guardar').removeAttr('disabled', 'disabled');
        }
        var ipt = JSON.stringify(ip); //Convierto la Lista de Productos a un JSON para procesarlo en tu controlador
        $('#ListaPro').val(encodeURIComponent(ipt));
    }

    function agregarProducto() {

        var sel = '.'; //Capturo el Value del Producto
        var text = '.'; //Capturo el Nombre del Producto- Texto dentro del Select


        var sptext = text.split();

        var newtr = '<tr class="item"  data-id="' + sel + '">';
        newtr = newtr + '<td class="iProduct" >' + sel + '</td>';
        newtr = newtr +
            '<td><input class="form-control" type="text" id="cartones[]" name="lista[]" onChange="Calcular(this);" value="1" /></td><td><input class="form-control" type="text" id="cantidad[]" name="lista[]" onChange="Calcular(this);" value="1" /></td><td><input class="form-control" type="text" id="nose[]" name="lista[]" onChange="Calcular(this);" value="1" /></td><td><input class="form-control" type="text" id="precunit[]" name="lista[]" onChange="Calcular(this);" value="0"/></td><td><input class="form-control" type="text" id="totalitem[]" name="lista[]" readonly /></td>';
        newtr = newtr +
            '<td><button type="button" class="btn btn-danger btn-xs remove-item" ><i class="fa fa-times"></i></button></td></tr>';

        $('#ProSelected').append(newtr); //Agrego el Producto al tbody de la Tabla con el id=ProSelected

        RefrescaProducto(); //Refresco Productos

        $('.remove-item').off().click(function(e) {
            var total = document.getElementById("total");
            total.innerHTML = parseFloat(total.innerHTML) - parseFloat(this.parentNode.parentNode.childNodes[5]
                .childNodes[0].value);
            $(this).parent('td').parent('tr').remove(); //En accion elimino el Producto de la Tabla
            if ($('#ProSelected tr.item').length == 0)
                $('#ProSelected .no-item').slideDown(300);
            RefrescaProducto();

            Calcular(e.target);
        });
        $('.iProduct').off().change(function(e) {
            RefrescaProducto();

        });
    }


    function Calcular(ele) {
        var cantidad = 0,
            precunit = 0,
            totalitem = 0,
            nose = 0,
            vol = 0,
            cartones = 0;
        var tr = ele.parentNode.parentNode;
        var nodes = tr.childNodes;

        for (var x = 0; x < nodes.length; x++) {
            if (nodes[x].firstChild.id == 'cartones[]') {
                cartones = parseFloat(nodes[x].firstChild.value, 10);
            }

            if (nodes[x].firstChild.id == 'cantidad[]') {
                cantidad = parseFloat(nodes[x].firstChild.value, 10);
            }
            if (nodes[x].firstChild.id == 'nose[]') {
                nose = parseFloat(nodes[x].firstChild.value, 10);
            }
            if (nodes[x].firstChild.id == 'precunit[]') {
                precunit = parseFloat(nodes[x].firstChild.value, 10);
            }
            if (nodes[x].firstChild.id == 'totalitem[]') {
                anterior = nodes[x].firstChild.value;
                vol = (parseFloat(((precunit * cantidad * nose) / 1000000), 10)).toFixed(2);;
                totalitem = vol * cartones
                nodes[x].firstChild.value = totalitem;
            }
        }
        // Resultado final de cada fila ERROR, al editar o eliminar una fila
        var total = document.getElementById("total");
        
        if (total.innerHTML == 'NaN') {
            total.innerHTML = 0;
            // 
        }
        total.innerHTML = (parseFloat(total.innerHTML) + totalitem - anterior).toFixed(2);
        document.getElementById('volumen').value = total.innerHTML;

        

    }
</script>
