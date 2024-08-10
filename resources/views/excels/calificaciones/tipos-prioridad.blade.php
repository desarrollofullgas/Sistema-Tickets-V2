{{-- <table>
    <thead>
        <tr>
            <th colspan="6" style="background-color: #404040; color:white; font-weight: bold;">Tiempo promedio de respuesta (Hrs)</th>
        </tr>
        <tr>
            <th style="background-color: #FF0000; color:white; font-weight: bold;"></th>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Bajo</th>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Medio</th>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Alto</th>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Crítico</th>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Alto Crítico</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tablaTiempos as $kt => $tipo)    
            <tr>
                <td>{{$kt}}</td>
                @foreach ($tipo as $prioridad)
                    <td>{{$prioridad['cant']>0?number_format(($prioridad['suma']/$prioridad['cant']),2):0}}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table> --}}
@foreach ($tablas as $tabla)
    <table>
        <thead>
            <tr>
                <th rowspan="{{count($tabla['data'])+1}}">{{$tabla['tipo']}}</th>
                <th style="background-color: #FF0000; color:white; font-weight: bold;">Prioridad</th>
                <th style="background-color: #FF0000; color:white; font-weight: bold;">Abiertos</th>
                <th style="background-color: #FF0000; color:white; font-weight: bold;">En proceso</th>
                <th style="background-color: #FF0000; color:white; font-weight: bold;">Cerrados</th>
                {{-- <th style="background-color: #FF0000; color:white; font-weight: bold;">Vencidos</th> --}}
                <th style="background-color: #FF0000; color:white; font-weight: bold;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tabla['data'] as $item)    
                <tr>
                    <td>{{$item['prioridad']}}</td>
                    <td>{{$item['abiertos']}}</td>
                    <td @if ($item['procesos']>0) style="color:#E26B0A;"  @endif>{{$item['procesos']}}</td>
                    <td>{{$item['cerrados']}}</td>
                    {{-- <td @if ($item['vencidos']>0) style="color:#FF0000;"  @endif>{{$item['vencidos']}}</td> --}}
                    <td>{{$item['total']}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" style="background-color: #404040; color:white; font-weight: bold;">Total</td>
                @foreach ($totales as $total)
                    @if ($total['tipo']==$tabla['tipo'])
                        <td style="background-color: #404040; color:white; font-weight: bold;">{{$total['data']['abierto']}}</td>
                        <td style="background-color: #404040; color:white; font-weight: bold;">{{$total['data']['proceso']}}</td>
                        <td style="background-color: #404040; color:white; font-weight: bold;">{{$total['data']['cerrado']}}</td>
                        <td style="background-color: #404040; color:white; font-weight: bold;">{{$total['data']['total']}}</td>
                    @endif
                @endforeach
            </tr>
        </tbody>
    </table>
@endforeach