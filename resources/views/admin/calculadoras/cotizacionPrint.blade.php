<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Cotizacion</title>
    <style>
        @page {
            margin: 1cm;
            header: page-header;
        }

        header {
            /* position: fixed; */
            top: 0;
            left: 0;
            right: 0;
            height: 4cm;
            /* margin-bottom: 1cm; */
            /* background-color: #f2f2f2;
            border-bottom: 1px solid #ccc; */
            /* padding: 0.5cm; */
        }

        .page-break {
            page-break-before: always;
        }

        .header-left {
            float: left;
            width: 50%;
        }

        .header-right {
            float: right;
            width: 50%;
            text-align: right;
        }

        .logo {
            width: 5cm;
            height: 3cm;
            margin-right: 2cm;
            margin-bottom: 0.5cm;
        }

        .logo-container {
            background-color: #032950;
            display: flex;
            justify-content: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0.5cm;
            /* Ajusta el margen superior de la tabla según el espacio deseado */
        }

        #origen td {

            text-align: center;
            /* Ajusta el margen superior de la tabla según el espacio deseado */
        }


        th,
        #encabezado td:first-child {
            background-color: #032950;
            /* Color de fondo azul oscuro */
            color: #fff;
            /* Color de texto blanco */
        }

        #date td:first-child {
            background-color: #032950;
            /* Color de fondo azul oscuro */
            color: #fff;
            /* Color de texto blanco */
        }

        #date td:nth-child(3) {
            background-color: #032950;
            /* Color de fondo azul oscuro */
            color: #fff;
            /* Color de texto blanco */
        }

        td {
            border: 1px solid #ccc;
            padding: 0.2cm;
        }

        .example {
            font-size: 12px;
        }

        .small-text {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <header id="page-header">
        <div class="header-left">
            <h2>COTIZACIÓN</h2>
            <h5>SERVICIOS MARITIMOS LCL</h5>
            <div style="margin-top: 1cm;"></div>
            <h5>{{ $cotizacion->usuario->name }}</h5>
            <p><b>IMPORCOMEX</b></p>
        </div>
        <div class="header-right">
            <div class="logo-container">
                <img src="{{ asset('imagenes/logo.png') }}" alt="Logo de la Empresa" class="logo">
            </div>
            <table class="table table-sm example" id="encabezado">
                <tr>
                    <td class="table-dark">COTIZACION No.</td>
                    <td>{{ $cotizacion->id }}</td>
                </tr>
                <tr>
                    <td class="table-dark">FECHA COTIZACION</td>
                    <td>{{ date('Y-m-d', strtotime($cotizacion->time)) }}</td>
                </tr>
                <tr>
                    <td class="table-dark">FECHA VIGENCIA</td>
                    <td>Dato 4</td>
                </tr>
            </table>
        </div>
        <div style="clear: both;"></div>
    </header>
    <div style="margin-top: 3cm;"></div>
    <div class="cuerpo mt-3">
        <p>Me permito a continuación detallar la cotización de servicios por usted requerida</p>
        <table class="table table-bordered example" id="date">
            <tbody>
                <tr>
                    <td>Port of Origin:</td>
                    <td>SHENZHEN, CHINA</td>
                    <td>Estimated Transit Time:</td>
                    <td>30-35 días aprox</td>
                </tr>
                <tr>
                    <td>Port of Destination:</td>
                    <td>GUAYAQUIL</td>
                    <td>Tipo de Carga:</td>
                    <td>{{ $cotizacion->modalidad->modalidad }}</td>
                </tr>
                <tr>
                    <td>Incoterm:</td>
                    <td>{{ $incoterm->name }}</td>
                    <td>Cbm:</td>
                    <td>{{ $cotizacion->volumen }}</td>
                </tr>
                <!-- Puedes agregar más filas según tus necesidades -->
            </tbody>
        </table>
        <table class="table table-light example">
            <thead class="thead-light">
                <tr>
                    <th>CONCEPTO</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>VALOR DEL FLETE MARITIMO</td>
                    <td>{{ $cotizacion->flete_maritimo }}$</td>
                </tr>
            </tbody>
        </table>
        <table class="table table-light example" id="origen">
            <thead class="thead-light">
                <tr>
                    <th></th>
                    <th>GASTOS DE ORIGEN</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($gastosOrigen as $item)
                        <td>{{ $item->nombre }}</td>
                    @endforeach
                    <td>TOTAL</td>
                </tr>
                <tr>
                    @foreach ($gastosOrigen as $item)
                        <td>{{ $item->valor }}$</td>
                    @endforeach
                    <td>{{ $cotizacion->gastos_origen }}$</td>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered example">
            <thead class="thead-light">
                <tr>
                    <th>GASTOS LOCALES</th>
                    <th>TARIFA</th>
                    <th>MINIMO</th>
                    <th>CALCULO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gastoSimple as $item)
                    <tr>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->valor }}</td>
                        <td>{{ $item->minimo }}</td>
                        <td>{{ $item->valor }}$</td>
                    </tr>
                @endforeach
                @foreach ($gastosCompuesta as $item)
                    <tr>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->valor }}</td>
                        <td>{{ $item->minimo }}</td>
                        @if ($item->valor * $cotizacion->volumen <= $item->minimo)
                            <td>{{ $item->minimo }}$</td>
                        @else
                            <td>{{ $item->valor * $cotizacion->volumen }}$</td>
                        @endif
                    </tr>
                @endforeach
                <tr>
                    <td>COLLECT FEE</td>
                    <td></td>
                    <td></td>
                    <td>{{ $cotizacion->collect }}$</td>
                </tr>
                <tr class="table-danger">
                    <td></td>
                    <td></td>
                    <td>GASTOS LOCALES</td>
                    <td>{{ $cotizacion->gastos_sin_iva }}$</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>IVA 12%</td>
                    <td>{{ number_format($cotizacion->gastos_sin_iva * 0.12, 2) }}$</td>

                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>TOTAL INCL IVA</td>
                    <td>{{ number_format($cotizacion->gastos_local, 2) }}$</td>
                </tr>
            </tbody>
        </table>
        
        <div style="margin-top: 0.5cm;"></div>
        {{-- <div class="page-break"></div> --}}
        <ul>
            <li class="small-text">Aplica el beneficio de Exoneración de Garantía</li>
            <li class="small-text"> Tarifa aplica para carga general apilable: no peligrosa, no sobredimensionada, no
                perecedera, sin sobrepeso
                y correctamente embalada para embarque marítimo.</li>
            <li class="small-text">Pesos y dimensiones se verifican antes del embarque, cualquier variación modifica la
                oferta
            </li>
            <li class="small-text"> Estas tarifas no incluyen tasas, impuestos, multas, bodegajes, aforos; en origen o
                en destino.</li>
            <li class="small-text">Tarifas locales no graban el 12 % IVA .
            </li>
            <li class="small-text">Tipo de cambio varia acorde a fecha de arribo de la carga</li>
        </ul>
        <div style="margin-top: 0.5cm;"></div>
        <p class="small-text">Agradecemos la confianza y apertura para presentarle nuestra propuesta, para HA CARGO será
            un gusto poder coordinar este embarque.</p>
    </div>
</body>

</html>
