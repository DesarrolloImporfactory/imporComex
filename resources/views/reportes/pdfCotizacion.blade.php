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

        main{
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

            /** Extra personal styles **/
            /* background-color: #937DC2; */
            color: black;
            text-align: center;
            line-height: 35px;
        }
        .termino{
            color: red;
        }
    </style>
    <link rel="stylesheet" href="{{ public_path('css/invoices.css')}}" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>


    <footer>
        
    <p><b>Dirección: </b> Barrio la Merced, Calles: Calixto Pino y Sánchez de Orellana -  <b>Cel. </b> 09999999999  &copy; <?php echo date("Y");?>  </p> 
    </footer>
<body>
    @include('components.cotizacion')
    <br>
    <b class="termino">TERMINOS Y CONDICIONES</b>
        <p>
            **Debido a la inestabilidad en los servicios en todo el MUNDO: precios y espacios están sujeto a confirmación por parte de las compañías navieras/aerolíneas, NO podemos asegurar las salidas de los navíos/aviones dentro de la vigencia de la oferta, por tanto se aplicará el precio del flete marítimo/aéreo acorde a la fecha de salida real informada en el BL/AWB.**

**De necesitar con URGENCIA espacios, favor solicitar TARIFA diferenciada: EXPRESS y/o PRIORITY. Ninguna Línea Naviera, ni aerolínea se responsabiliza por extravío, daños o recepción de carga en estado inapropiado por ello recomendamos contraten Seguro Todo Riesgo para estos casos.**

        </p>
</body>
</html>