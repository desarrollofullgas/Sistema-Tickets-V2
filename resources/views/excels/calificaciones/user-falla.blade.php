<table>
    <thead>
        <tr>
            <th>Agente</th>
            <th>Servicio</th>
            <th>Falla</th>
            <th>Abiertos</th>
            <th>En proceso</th>
            {{-- <th>Vencidos</th> --}}
            <th>Cerrados</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tablas as $tabla)
            <tr>
                <td rowspan="{{$tabla['rows']}}">{{$tabla['user']}}</td>
                <td rowspan="{{count($tabla['servicios'][0]['datos'])}}">{{$tabla['servicios'][0]['servicio']}}</td>
                <td>{{$tabla['servicios'][0]['datos'][0]['falla']}}</td>
                <td>{{$tabla['servicios'][0]['datos'][0]['abierto']}}</td>
                <td @if ($tabla['servicios'][0]['datos'][0]['proceso']>0) style="color:#E26B0A;"  @endif>{{$tabla['servicios'][0]['datos'][0]['proceso']}}</td>
                {{-- <td @if ($tabla['servicios'][0]['datos'][0]['vencido']>0) style="color:#FF0000;"  @endif>{{$tabla['servicios'][0]['datos'][0]['vencido']}}</td> --}}
                <td>{{$tabla['servicios'][0]['datos'][0]['cerrados']}}</td>
                <td>{{$tabla['servicios'][0]['datos'][0]['total']}}</td>
            </tr>
            @foreach ($tabla['servicios'][0]['datos'] as $key => $item)
                @if ($key!=0)    
                    <tr>
                        <td>{{$item['falla']}}</td>
                        <td>{{$item['abierto']}}</td>
                        <td @if ($item['proceso']>0) style="color:#E26B0A;"  @endif>{{$item['proceso']}}</td>
                        {{-- <td @if ($item['vencido']>0) style="color:#FF0000;"  @endif>{{$item['vencido']}}</td> --}}
                        <td>{{$item['cerrados']}}</td>
                        <td>{{$item['total']}}</td>
                    </tr>
                @endif
            @endforeach
            @foreach ($tabla['servicios'] as $key => $servicio)
                @if ($key!=0)
                    <tr>
                        <td rowspan="{{count($servicio['datos'])}}">{{$servicio['servicio']}}</td>
                        <td>{{$servicio['datos'][0]['falla']}}</td>
                        <td>{{$servicio['datos'][0]['abierto']}}</td>
                        <td @if ($servicio['datos'][0]['proceso']>0) style="color:#E26B0A;"  @endif>{{$servicio['datos'][0]['proceso']}}</td>
                        {{-- <td @if ($servicio['datos'][0]['vencido']>0) style="color:#FF0000;"  @endif>{{$servicio['datos'][0]['vencido']}}</td> --}}
                        <td>{{$servicio['datos'][0]['cerrados']}}</td>
                        <td>{{$servicio['datos'][0]['total']}}</td>
                    </tr>
                    @foreach ($servicio['datos'] as $clave => $falla)
                        @if ($clave !=0)
                            <tr>
                                <td>{{$falla['falla']}}</td>
                                <td>{{$falla['abierto']}}</td>
                                <td @if ($falla['proceso']>0) style="color:#E26B0A;"  @endif>{{$falla['proceso']}}</td>
                                {{-- <td @if ($falla['vencido']>0) style="color:#FF0000;"  @endif>{{$falla['vencido']}}</td> --}}
                                <td>{{$falla['cerrados']}}</td>
                                <td>{{$falla['total']}}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach
            <tr>
                <td colspan="3" style="background-color: #404040; color:white; font-weight: bold;"> TOTAL DE AGENTE {{$tabla['user']}}</td>
                <td style="background-color: #404040; color:white; font-weight: bold;">{{$tabla['totales']['abiertos']}}</td>
                <td style="background-color: #404040; color:white; font-weight: bold;">{{$tabla['totales']['proceso']}}</td>
                <td style="background-color: #404040; color:white; font-weight: bold;">{{$tabla['totales']['cerrados']}}</td>
                <td style="background-color: #404040; color:white; font-weight: bold;">{{$tabla['totales']['totGral']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>