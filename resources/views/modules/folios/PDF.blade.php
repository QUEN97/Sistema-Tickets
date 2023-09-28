<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page{
            margin: 3cm 1.5cm 3cm 1.5cm;
        }
        .header{
            position: fixed;
            top: -2cm;
            left: 0cm;
        }
        .footer{
            position: fixed;
            bottom: -3cm;
            left: 0cm;
        }
        html{
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
        .arial{
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 400;
        }
        .table{
            border:1px black solid;
            border-collapse: collapse;
        }
        .table tr th{
            border: 1px black solid;
            padding: 5px;
        }
        .bg-gray{
            background-color: rgb(242, 242, 242);
        }
        .text-left{
            text-align: left;
        }
        .text-center{
            text-align: center;
        }
        .text-md{
            font-size: 14px;
        }
        .text-sm{
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <table width="100%">
            <tr>
                <th><img src="{{public_path('storage/logo/FullGas.png')}}" alt="" width="200px"></th>
                <th>{{strtoupper($tipo)}} DE EQUIPOS Y MATERIALES (ESTACIONES)</th>
                <th><img src="{{public_path('storage/logo/AbejaFullGas2.png')}}" alt="" width="200px"></th>
            </tr>
        </table>
    </div>
    <br><br><br>
    <table  width="100%" class="text-md">
        <tr>
            <th colspan="2">
                <table class="table bg-gray text-left">
                    <tr>
                        <th>RESPONSABLE DE ENTREGA:</th>
                        <th>{{$folio->usuario->name}}</th>
                    </tr>
                    <tr>
                        <th>QUIEN SOLICITA:</th>
                        <th>ERIKA GUTIERREZ</th>
                    </tr>
                    <tr>
                        <th>MOTIVO:</th>
                        <th>{{$folio->motivo}}</th>
                    </tr>
                </table>
            </th>
            <th></th>
            <th></th>
            <th>
                <table width="100%" class="table bg-gray">
                    <tr>
                        <th>Fecha:</th>
                        <th>{{$folio->created_at}}</th>
                    </tr>
                    <tr>
                        <th>FOLIO:</th>
                        <th>{{$folio->folio->folio}}</th>
                    </tr>
                </table>
            </th>
        </tr>
    </table>
    <br>
    <table width="100%" class="table">
        <thead>
            <tr class="bg-gray">
                <th>#TICKET</th>
                <th>ESTACIÓN</th>
                <th>EQUIPO/MATERIAL</th>
                <th>SERIE</th>
                <th>UNIDAD</th>
                <th>CANTIDAD</th>
                <th>OBSERVACIÓN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($folio->productos as $producto)
            <tr class="arial text-sm">
                <th>{{isset($producto->ticket->id)?'#'.$producto->ticket->id : 'S/N'}}</th>
                <th>{{isset($producto->estacion->name)?$producto->estacion->name : 'S/N'}}</th>
                <th>{{$producto->producto->name}}</th>
                <th>{{$producto->serie->serie}}</th>
                <th>{{$producto->producto->unidad}}</th>
                <th>{{$producto->cantidad}}</th>
                <th>{{$producto->observacion}}</th>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <br>
    <table width="100%" class="text-md">
        <tr>
            <th width="65%"></th>
            <th>
                <hr>
                NOMBE Y FIRMA DEL SOLICITANTE
            </th>
        </tr>
    </table>
    <br>
    <br>
    <div class="text-sm">
        <p>
            AL FIRMAR EL PRESENTE RESGUARDO ME OBLIGO A:
        </p>
        <p>
            CUBRIRÉ POR MI CUENTA EL IMPORTE DE LOS DAÑOS, FALTANTE DE EQUIPO, ACCESORIOS O HERRAMIENTAS DURANTE EL TIEMPO QUE EL BIEN ESTÉ BAJO MI RESGUARDO.
        </p>
        <p>
            CONSERVAR EN OPTIMAS CONDICIONES DE FUNCIONAMIENTO DEL BIEN, ASÍ COMO VIGILAR EL OPORTUNO MANTENIMIENTO DE ESTE.
        </p>
        <p>
            QUE SE ME RESPONSABILICE DE LO QUE PROCEDA EN CASO DE INCUMPLIMIENTO AL CUALQUIERA DE LOS PUNTOS ANTERIORES.
        </p>
    </div>
    <br>
    <div class="text-sm footer">
        <div class="text-center">
            <p><b>www.fullgas.com.mx</b></p>
            <p><b>97125 Mérida, Yucatán, México | sistemas@fullgas.com.mx | 9999269020 | 9999686823</b></p>
        </div>
        <img src="{{public_path('storage/logo/FullPower.png')}}" alt="" width="100%">
    </div>
</body>
</html>