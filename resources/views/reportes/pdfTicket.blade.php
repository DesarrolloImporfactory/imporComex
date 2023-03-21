
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <style>
        * {
            font-family: 'Lato', sans-serif;
        }
        .content-table {
            border-collapse: collapse;
            margin: 5px 0;
            font-size: 1em;
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
            padding: 12px 15px;
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
    </style>
    <link rel="stylesheet" href="{{ asset('css/invoices.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>

    @php
        $j = 1;
    @endphp
    @foreach ($proveedores as $proveedor)
        @for ($i = 0; $i < $proveedor->total_cartones; $i++)
        <br>
            <div class="general">
                <div class="invoice-box">
                    <table class="content-table">
                        <tr>
                            <td class="w-50">
                                <div><span class="bold">TO: </span>{{ $cotizacion->usuario_id }}</div>


                            </td>

                            <td class="text-left">

                                <div><span class="bold">QUOTATION:</span> #{{ $cotizacion->id }}</div>
                            </td>
                        </tr>
                    </table>
                    

                    {{-- invoice items --}}
                    <table class="content-table" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th></th>
                                <th>PRODUCT DESCRIPTION</th>
                                <th></th>

                            </tr>
                        </thead>
                    </table>
                    <div class="mt">
                        {{-- <div class="div1"><span class="bold">NAME PRODUCT :</span> {{ $cotizacion->producto }}</div><br> --}}
                        <div class="div1"><span class="bold">SUPPLIER NAME :</span> {{ $proveedor->nombre_pro }}
                        </div><br>
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

</body>

</html>
