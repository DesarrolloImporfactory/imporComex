<div class="general">
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="w-50 ">
                    {{-- Using a URL from another domain may not shown the image correctly --}}
                    {{-- <img src="https://via.placeholder.com/400x100?text=Your%20Company%20Logo" style="width: 100%; max-width: 300px"> --}}

                    @if ($inBackground)
                        <img src="{{ asset('Imagen2.png') }}" alt="" style="width: 50%;">
                    @else
                        <img src="{{ public_path('Imagen2.png') }}" style="width: 50%;">
                    @endif

                </td>

                <td class="text-center">
                    <div><span class="bold">Cotización: </span>#{{ $cotizacion->id }}</div>
                    

                </td>
            </tr>
        </table>
        <br>
        <table class="items-table mt" id="th" cellpadding="0" cellspacing="0">
            <thead>
                <tr class="heading text-center">
                    <th></th>
                    <th>COTIZACIÓN DE IMPORTACIÓN</th>
                    <th></th>

                </tr>
            </thead>
        </table>
        <div class="mt">
            <div class="div1 text-center"><span class="bold">Cliente: </span>{{ $cotizacion->usuario->name }}</div><br>
        </div>
        <table class=" div1 " id="th" cellpadding="0" cellspacing="0">
            <thead>
                <tr class="heading text-center">
                    <th><b>Origen: </b>{{ $cotizacion->origen }}</th>
                    <th><b>Destino:</b>{{ $cotizacion->pais->nombre_pais }}</th>
                    <th><b>Fecha:</b>{{$carbon}}</th>

                </tr>
            </thead>
        </table><br>

        <table class="items-table mt" id="th" cellpadding="0" cellspacing="0">
            <thead>
                <tr class="heading text-center">
                    <th></th>
                    <th>INFORMACIÓN GENERAL</th>
                    <th></th>

                </tr>
            </thead>
        </table>
        <table class="table table-striped" id="" cellpadding="0" cellspacing="0">
            <thead>
                <tr class="heading text-center">
                    <th>Descripción</th>
                    <th>Información</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td><b>Nombre de producto: </b></td>
                    <td>{{ $cotizacion->producto }}</td>
                    
                  </tr>
                  <tr>
                    <td><b>Partida arancelaria:</b></td>
                    <td>Pendiente</td>
                  </tr>
                  <tr>
                    <td><b>Cantidad total de productos:</b></td>
                    <td>{{$cotizacion->total_productos}}</td>
                  </tr>
                  <tr>
                    <td><b>CBM Total: </b></td>
                    <td>{{ $cotizacion->volumen }}</td>
                  </tr>
                  <tr>
                    <td><b>Peso bruto total: </b></td>
                    <td>{{ $cotizacion->peso }}</td>
                  </tr>
                  <tr>
                    <td><b>Valor Factura EXW + envío a bodegas: </b></td>
                    <td>Pendiente</td>
                  </tr>
                  <tr>
                    <td><b>Lugar de entrega: </b></td>
                    <td>{{ $cotizacion->ciudad_entrega }},{{ $cotizacion->direccion }}</td>
                  </tr>
            </tbody>
        </table>
       
        <table class="items-table mt" id="th" cellpadding="0" cellspacing="0">
            <thead>
                <tr class="heading text-center">
                    <th></th>
                    <th>COTIZADOR</th>
                    <th></th>

                </tr>
            </thead>
        </table>

         <table class="table table-striped" id="" cellpadding="0" cellspacing="0">
            <thead>
                <tr class="heading text-center">
                    <th>Gtos. Importación</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>Total Servicio Logístico</b></td>
                    <td>Pendiente</td>
                </tr>
                <tr>
                    <td><b>Impuestos apróx. </b></td>
                    <td>Pendiente</td>
                </tr>
                <tr>
                    <td><b>Gtos. TOTAL A PAGAR: </b></td>
                    <td>{{ $cotizacion->total }}$</td>
                </tr>
            </tbody>
        </table><br>
    </div>
</div>