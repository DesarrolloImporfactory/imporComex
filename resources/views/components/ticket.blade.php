<div class="general"><br>
    <div class="form-row div1">
        <div class="col-md-4 "><b>TO:</b></div>
        <div class="col-md-8 ">{{$cotizacion->usuario_id}}</div>
    </div><br>

    <div class="form-row div1">
        <div class="col-md-4 "><b>QUOTATION:</b></div>
        <div class="col-md-8 ">{{$cotizacion->id}}</div>
    </div><br>
    <div class="form-row encabezado ">
        <div class="col-md-12 text-center"><b>CARTON INFORMATION</b></div>
    </div><br>
    <div class="form-row div1">
        <div class="col-md-4 "><b>QTY GOODS:</b></div>
        <div class="col-md-8 ">{{$cotizacion->total_productos}}</div>
    </div><br>
    <div class="form-row div1">
        <div class="col-md-4 "><b>GROSS WEIGHT : </b></div>
        <div class="col-md-8 ">{{$cotizacion->peso}}</div>
    </div><br>
    <div class="form-row encabezado ">
        <div class="col-md-12 text-center"><b>PRODUCT DESCRIPTION</b></div>
    </div><br>
    <div class="form-row div1">
        <div class="col-md-4 "><b>NAME PRODUCT : </b></div>
        <div class="col-md-8 ">{{$cotizacion->producto}}</div>
    </div><br>
    <div class="form-row div1">
        <div class="col-md-4 "><b>SUPPLIER NAME : </b></div>
        <div class="col-md-8 "><b>Partida arancelaria:</b></div>
    </div><br>
    <div class="form-row div1">
        <div class="col-md-12"><b>SHIPPING MARK IMPORTCOMEXSAS-ECGLY : </b>{{$cotizacion->pais->nombre_pais}}</div>
        
    </div><br>
    <div class="form-row div3">
        <div class="col-md-12 text-center"><b>CARTON No.: 1-8</b></div>
        
    </div><br>
    <div class="code">
        {!! DNS1D::getBarcodeHTML("$id", 'C128A')!!}
    </div><br>
</div>