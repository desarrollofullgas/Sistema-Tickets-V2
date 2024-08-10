<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hoja de servicio</title>
    <style>
        .table{
            border:1px black solid;
            border-collapse: collapse;
        }
        .table tr th{
            border: 1px black solid;
            padding: 5px;
        }
        .firma{
            padding: 15px;
            height: 40px;
        }
        .bg-gray{
            background-color: rgb(242, 242, 242);
        }
        td{
            border: 1px black solid;
            padding: 5px;
        }
        h2{
            text-align: center;
            font-size: 18px;
            margin: 0px;
            padding: 0px;
        }
        p{
            text-align: center;
            margin: 0px;
            padding: 0px;
        }
    </style>
</head>
<body>
    <table width="100%">
        <tr>
            <th><img src="{{public_path('storage/logo/FullGas.png')}}" alt="" width="200px"></th>
            <th>ORDEN DE SERVICIO</th>
            <th><img src="{{public_path('storage/logo/AbejaFullGas2.png')}}" alt="" width="200px"></th>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <th>
                <table class="table bg-gray">
                    <tr>
                        <th>ESTACIÓN</th>
                        <th>{{$visita->estacion->name}}</th>
                    </tr>
                    <tr>
                        <th>AGENTE</th>
                        <th>{{$visita->solicita->name}}</th>
                    </tr>
                </table>
            </th>
            <th>
                <table class="table bg-gray">
                    <tr>
                        <th>FECHA</th>
                        <th>{{$visita->retirada}}</th>
                    </tr>
                    <tr>
                        <th>#F.S</th>
                        <th>{{$visita->id}}</th>
                    </tr>
                </table>
            </th>          
        </tr>
    </table>
    <br>
    <table width="100%" class="table">
        <tr class="bg-gray">
            <th>DESCRIPCIÓN:</th>
        </tr>
        <tr>
            <td>{{$visita->motivo_visita}}</td>
        </tr>
    </table>
    <br><br>
    <table width="100%" class="table">
        <tr class="bg-gray">
            <th>OBSERVACIONES:</th>
        </tr>
        <tr>
            <td>{{$visita->observacion_visita}}</td>
        </tr>
    </table>
    <br><br>
    <table width="100%" class="table">
        <tr class="bg-gray">
            <th colspan="2">
                <h2><b>AUTORIZACIONES</b></h2>
                <p><b>El formato debe ser llenado por el responsable de Soporte Fullgas y Firmando por el responsable de la estación.</b></p>
            </th>
        </tr>
        <tr>
            <td>De conformidad por parte de quien recibe (Nombre, Fecha y Firma)</td>
            <td>Responsable Soporte Fullgas (Nombre, Fecha y Firma)</td>
        </tr>
        <tr>
            <th class="firma"></th>
            <th class="firma"></th>
        </tr>
    </table>
</body>
</html>