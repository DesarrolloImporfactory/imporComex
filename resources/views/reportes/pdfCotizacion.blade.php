<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        /** Define the margins of your page **/
        @page {
            margin-bottom: 100px;
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 10px;
        }

        main {
            position: relative;
            top: -10px;

            height: 0px;
        }


        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
            border: solid;
            /** Extra personal styles **/
            /* background-color: #937DC2; */
            color: black;
            text-align: center;
            line-height: 35px;
        }

        .content-table {
            border-collapse: collapse;
            margin: 3px 0;
            font-size: 1rem;
            font-family: sans-serif;
            min-width: 450px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        .content-table thead tr {
            background-color: #6D727A;
            color: #ffffff;
            text-align: middle;
        }

        .content-table th,
        .content-table td {
            padding: 6px 9px;
        }

        .content-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .content-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .content-table tbody tr:last-of-type {
            border-bottom: 2px solid black;
        }

        .termino {
            color: red;
        }

        .condiciones {
            margin: 1%;
            text-align: justify;
        }
    </style>
    
    <link rel="stylesheet" href="{{ asset('css/invoices.css') }}">
    {{-- <link rel="stylesheet" href="{{ public_path('css/invoices.css')}}" type="text/css" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>


<footer>

    <p><b>Dirección: </b> Edificio el Cisne, Colon y Quito 170522 - <b>Cel. </b> +593 998818724 &copy;
        <?php echo date('Y'); ?> </p>
</footer>

<body>

    <div class="general">
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="w-50 text-center">
                        {{-- Using a URL from another domain may not shown the image correctly --}}
                        {{-- <img src="https://via.placeholder.com/400x100?text=Your%20Company%20Logo" style="width: 100%; max-width: 300px"> --}}

                        @if ($inBackground)
                            <img src="{{ asset('storage/imporcomexImage/Imagen2.png') }}" alt=""
                                style="width: 50%;">
                        @else
                            <img src="{{ public_path('Imagen2.png') }}" style="width: 50%;">
                        @endif

                    </td>

                    <td class="text-center">
                        <div><span class="bold">Cotización: </span>#{{ $cotizacion->id }}</div>


                    </td>
                </tr>
            </table>

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
                <div class="div1 "><span class="bold">Cliente: </span>{{ $cotizacion->usuario->name }}
                </div>
            </div>

            <table class="content-table" id="th" cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="heading text-center">
                        <td><b>Origen: </b>{{ $cotizacion->origen }}</td>
                        <td><b>Destino: </b>{{ $cotizacion->pais->nombre_pais }}</td>
                        <td><b>Fecha: </b>{{ $carbon }}</td>

                    </tr>
                </thead>
            </table>


            <div class="row">
                <div class="col-md-12 text-center">
                    <b> INFORMACIÓN GENERAL</b>
                </div>
            </div>

            <table class="content-table">
                <thead>
                    <tr>
                        <th>DESCRIPCION</th>
                        <th>INFORMACION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>Nombre de producto: </b></td>
                        <td>
                            @foreach ($productos as $item)
                                <li>{{ $item->insumo->nombre }}</li>
                            @endforeach
                        </td>
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
                        <td><b>Lugar de entrega: </b></td>
                        <td>{{ $cotizacion->ciudad->nombre_provincia }} - {{ $cotizacion->ciudad->nombre_canton }}
                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="row">
                <div class="col-md-12 text-center">
                    <b>COTIZADOR</b>
                </div>
            </div>
            <table class="content-table">
                <thead>
                    <tr>
                        <th>GASTOS DE IMPORTACION</th>
                        <th>PRECIO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>Total Servicio Logístico</b></td>
                        <td>{{ $cotizacion->total_logistica }}$</td>
                    </tr>
                    <tr>
                        <td><b>Impuestos apróximados </b></td>
                        <td>{{ $cotizacion->total_impuesto }}$</td>
                    </tr>

                </tbody>
            </table>
            <table class="content-table">
                <thead>
                    <tr>
                        <th>PAGO PROVEEDOR</th>
                        <th>PRECIO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>Valor de compra. </b></td>
                        <td>{{ $cotizacion->total_fob }}$</td>
                    </tr>
                    <tr>
                        <td><b>ISD. </b></td>
                        <td>{{ $cotizacion->ISD }}$</td>
                    </tr>
                    <tr>
                        <td><b>Comisión bancaria. </b></td>
                        <td>{{ $cotizacion->comision }}$</td>
                    </tr>
                    <tr>
                        <td><b>TOTAL PAGO A PROVEEDOR: </b></td>
                        <td>{{ $cotizacion->total_fob  +  $cotizacion->ISD + $cotizacion->comision}}$</td>
                    </tr>
                    <tr>
                        <td><b>TOTAL INVERSIÓN: </b></td>
                        <td>{{ $cotizacion->total }}$</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="condiciones">
            <b class="termino">TERMINOS Y CONDICIONES</b>
            <p style="font-size: 10px; font-weight: bold;">
                **Debido a la inestabilidad en los servicios en todo el MUNDO: precios y espacios están sujeto a
                confirmación
                por parte de las compañías navieras/aerolíneas, NO podemos asegurar las salidas de los navíos/aviones
                dentro
                de
                la vigencia de la oferta, por tanto se aplicará el precio del flete marítimo/aéreo acorde a la fecha de
                salida
                real informada en el BL/AWB.**

                **De necesitar con URGENCIA espacios, favor solicitar TARIFA diferenciada: EXPRESS y/o PRIORITY. Ninguna
                Línea
                Naviera, ni aerolínea se responsabiliza por extravío, daños o recepción de carga en estado inapropiado
                por
                ello
                recomendamos contraten Seguro Todo Riesgo para estos casos.**

            </p>
        </div>
    </div>
</body>

</html>
