<div class="general">
    <div class="form-row  ">
        <div class="col-md-12 ">
            <p class="float-right"><b>Cotización: </b>{{ $cotizacion->id }}</p>
        </div>
    </div>

    <div class="form-row encabezado ">
        <div class="col-md-12 text-center"><b>COTIZACIÓN DE IMPORTACIÓN</b></div>
    </div><br>
    <div class="form-row encabezado ">
        <div class="col-md-12 text-center"><b>Cliente: </b> {{ $cotizacion->usuario->name }}</div>
    </div><br>
    <div class="form-row div1 text-center">
        <div class="col-md-4 "><b>Origen: </b>{{ $cotizacion->origen }}</div>
        <div class="col-md-4 "><b>Destino:</b>{{ $cotizacion->pais->nombre_pais }}</div>
        <div class="col-md-4 "><b>Fecha:</b>{{$carbon}}</div>
    </div><br>
    <div class="form-row encabezado ">
        <div class="col-md-12 text-center"><b>INFORMACIÓN GENERAL</b></div>
    </div><br>
    <div class="form-row div2 text-center">
        <div class="col-md-6 "><b>Descripción</b></div>
        <div class="col-md-6 "><b>Información</b></div>
    </div><br>
    <div class="form-row div1">
        <div class="col-md-6 "><b>Nombre de producto: </b>{{ $cotizacion->producto }}</div>
        <div class="col-md-6 "><b>Partida arancelaria:</b></div>
    </div><br>
    <div class="form-row div1">
        <div class="col-md-6 "><b>Cantidad total de productos:</b>{{$cotizacion->total_productos}}</div>
        <div class="col-md-6 "><b>CBM Total: </b>{{ $cotizacion->volumen }}</div>
    </div><br>
    <div class="form-row div1">
        <div class="col-md-6 "><b>Peso bruto total: </b> {{ $cotizacion->peso }}</div>
        
    </div><br>
    <div class="form-row div1 ">
        <div class="col-md-12 "><b>Valor Factura EXW + envío a bodegas: </b></div>
    </div><br>
    <div class="form-row div1">
        
        <div class="col-md-6 "><b>Lugar de entrega: </b>
            {{ $cotizacion->ciudad_entrega }},{{ $cotizacion->direccion }}</div>
    </div><br>
    <div class="form-row encabezado ">
        <div class="col-md-12 text-center"><b>COTIZADOR</b></div>
    </div><br>
    <div class="form-row div2 text-center">
        <div class="col-md-6 "><b>Gtos. Importación </b></div>
        <div class="col-md-6 "><b>Precio</b></div>
    </div><br>
    <div class="form-row div1">
        <div class="col-md-6 "><b>Total Servicio Logístico</b></div>
        <div class="col-md-6 "><b>Impuestos apróx. </b></div>
    </div><br>
    <div class="form-row div1">
        <div class="col-md-12 "><b>Gtos. TOTAL A PAGAR: </b>{{ $cotizacion->total }}$</div>

    </div>
</div>