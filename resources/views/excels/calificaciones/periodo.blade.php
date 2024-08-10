<table>
    <thead>
        <tr>
            <th></th>
            <th>TICKETS DEL PERIODO</th>
            <th>PENDIENTES POR SOLUCIONAR</th>
            {{-- <th>DENTRO DEL NIVEL DE SERVICIO</th>
            <th>FUERA DEL NIVEL DE SERVICIO</th>
            <th>TICKETS DENTRO DE HORARIO</th>
            <th>TICKETS FUERA DE HORARIO</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($arrTipos as $tipo)    
            <tr>
                <td>{{$tipo[0]}}</td>
                <td>{{$tipo['total']}}</td>
                <td>{{$tipo['pendientes']}}</td>
                {{-- <td>{{$tipo['dentro']}}</td>
                <td>{{$tipo['fuera']}}</td>
                <td>{{$tipo['inHr']}}</td>
                <td>{{$tipo['fHr']}}</td> --}}
            </tr>
        @endforeach
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th style="background-color: #FF0000; color:white; font-weight: bold;"></th>
            @foreach ($tablaAreas as $area)
                <th style="background-color: #FF0000; color:white; font-weight: bold;">{{$area['area']}}</th>
            @endforeach
            <th style="background-color: #FF0000; color:white; font-weight: bold;">TOTAL</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>ACTIVIDAD</td>
            @foreach ($tablaAreas as $area)
                <td>{{$area['datos']['ACTIVIDAD']}}</td>
            @endforeach
            <td>{{$totales['ACTIVIDAD']}}</td>
        </tr>
        <tr>
            <td>INCIDENTE</td>
            @foreach ($tablaAreas as $area)
                <td>{{$area['datos']['INCIDENTE']}}</td>
            @endforeach
            <td>{{$totales['INCIDENTE']}}</td>
        </tr>
        <tr>
            <td>SOLICITUD</td>
            @foreach ($tablaAreas as $area)
                <td>{{$area['datos']['SOLICITUD']}}</td>
            @endforeach
            <td>{{$totales['SOLICITUD']}}</td>
        </tr>
        <tr>
            <td style="background-color: #404040; color:white; font-weight: bold;">TOTAL</td>
            @foreach ($tablaAreas as $area)
                <td style="background-color: #404040; color:white; font-weight: bold;">{{$area['datos']['TOTAL']}}</td>
            @endforeach
            <td style="background-color: #404040; color:white; font-weight: bold;">{{$totales['TOTAL']}}</td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th colspan="2" style="background-color: #FF0000; color:white; font-weight: bold;">TICKETS</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>ABIERTOS</td>
            <td>{{$infoTcks['abiertos']}}</td>
        </tr>
        <tr>
            <td>CERRADOS</td>
            <td>{{$infoTcks['cerrados']}}</td>
        </tr>
        <tr>
            <td>EN PROCESO</td>
            <td>{{$infoTcks['proceso']}}</td>
        </tr>
        {{-- <tr>
            <td>VENCIDOS</td>
            <td>{{$infoTcks['vencidos']}}</td>
        </tr> --}}
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th colspan="2" style="background-color: #FF0000; color:white; font-weight: bold;">NIVEL DE SERVICIO (TICKETS CERRADOS)</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>DENTRO</td>
            <td>{{$lvServ['dentro']}}</td>
        </tr>
        <tr>
            <td>FUERA</td>
            <td>{{$lvServ['fuera']}}</td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th colspan="2" style="background-color: #FF0000; color:white; font-weight: bold;">HORARIO DE OFICINA</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>DENTRO</td>
            <td>{{$horario['dentro']}}</td>
        </tr>
        <tr>
            <td>FUERA</td>
            <td>{{$horario['fuera']}}</td>
        </tr>
    </tbody>
</table>