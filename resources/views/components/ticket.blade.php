@php
$j = 1;
@endphp
@foreach ($proveedores as $proveedor)
  
    @for ($i = 0; $i < $proveedor->total_cartones; $i++)
    <div class="general">
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="w-50">
                        <div><span class="bold">TO: </span>{{ $cotizacion->usuario_id }}</div>
                        

                    </td>

                    <td class="text-left">
                        
                        <div><span class="bold">QUOTATION:</span> #{{ $cotizacion->id }}</div>
                    </td>
                </tr>
            </table>
            <br>
            
            {{-- invoice items --}}
            <table class="items-table mt" cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="heading text-center">
                        <th></th>
                        <th>PRODUCT DESCRIPTION</th>
                        <th></th>

                    </tr>
                </thead>
            </table>
            <div class="mt">
                {{-- <div class="div1"><span class="bold">NAME PRODUCT :</span> {{ $cotizacion->producto }}</div><br> --}}
                <div class="div1"><span class="bold">SUPPLIER NAME :</span> {{ $proveedor->nombre_pro }}</div><br>
                <div class="div1"><span class="bold">SHIPPING MARK IMPORTCOMEXSAS-ECGLY
                        :</span>{{ $cotizacion->pais->nombre_pais }}</div><br>

            </div>
            <div class="mts"></div><br>
            <table class="mt">
                <tr>
                    <td class="w-50 text-center">
                        <b>CARTON No.: {{ $j++ }}</b>
                    </td>

                    <td class="w-50 text-center">
                        <div class="code">
                            {!! DNS1D::getBarcodeHTML("$barcode", 'C128A') !!}
                        </div><br>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @endfor
@endforeach
