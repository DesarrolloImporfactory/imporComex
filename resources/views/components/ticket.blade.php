@foreach ($proveedores as $proveedor)
    @php
        $i = 1;
    @endphp
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

                    <td class="text-left">
                        <div><span class="bold">TO: </span>{{ $cotizacion->usuario_id }}</div>
                        <div><span class="bold">QUOTATION:</span> #{{ $cotizacion->id }}</div>

                    </td>
                </tr>
            </table>
            <br>
            {{-- company information --}}

            <table class="items-table mt" id="th" cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="heading text-center">
                        <th></th>
                        <th>CARTON INFORMATION</th>
                        <th></th>

                    </tr>
                </thead>
            </table>

            {{-- customer information --}}
            <div class="mt">
                <div class="div1"><span class="bold">QTY GOODS:</span> {{ $cotizacion->total_productos }}</div><br>
                <div class="div1"><span class="bold">GROSS WEIGHT :</span>{{ $cotizacion->peso }}</div><br>

            </div>

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
                <div class="div1"><span class="bold">NAME PRODUCT :</span> {{ $cotizacion->producto }}</div><br>
                <div class="div1"><span class="bold">SUPPLIER NAME :</span> {{ $proveedor->nombre_pro }}</div><br>
                <div class="div1"><span class="bold">SHIPPING MARK IMPORTCOMEXSAS-ECGLY
                        :</span>{{ $cotizacion->pais->nombre_pais }}</div><br>

            </div>
            <div class="mts"></div><br>
            <table class="mt">
                <tr>
                    <td class="w-50 text-center">
                        <b>CARTON No.: {{ $i++ }}</b>
                    </td>

                    <td class="w-50 text-center">
                        <div class="code">
                            {!! DNS1D::getBarcodeHTML("$id", 'C128A') !!}
                        </div><br>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endforeach
