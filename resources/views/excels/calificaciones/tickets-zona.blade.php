{{-- tabla de zonas --}}
<table>
    <thead>
        <tr>
            <th colspan="5">Tickets por zona</th>
        </tr>
        <tr>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Zona</th>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Abiertos</th>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Cerrados</th>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">En proceso</th>
            {{-- <th style="background-color: #FF0000; color:white; font-weight: bold;">Vencidos</th> --}}
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tablaZonas as $key=>$zona)
            @if ($key<10)    
                <tr>
                    <td>{{$zona['zona']}}</td>
                    <td>{{$zona['abierto']}}</td>
                    <td>{{$zona['cerrado']}}</td>
                    <td @if ($zona['proceso']>0) style="color:#E26B0A;"  @endif>{{$zona['proceso']}}</td>
                    {{-- <td @if ($zona['vencido']>0) style="color:#FF0000;"  @endif>{{$zona['vencido']}}</td> --}}
                    <td>{{$zona['total']}}</td>
                </tr>
            @endif
        @endforeach
        <tr>
            <td style="background-color: #404040; color:white; font-weight: bold;"> TOTAL DE TICKETS DE LAS ZONAS</td>
            <td style="background-color: #404040; color:white; font-weight: bold;">{{$totalZonas['abiertos']}}</td>
            <td style="background-color: #404040; color:white; font-weight: bold;">{{$totalZonas['cerrados']}}</td>
            <td style="background-color: #404040; color:white; font-weight: bold;">{{$totalZonas['proceso']}}</td>
            <td style="background-color: #404040; color:white; font-weight: bold;">{{$totalZonas['totGral']}}</td>
        </tr>
    </tbody>
</table>
{{-- tabla de usuarios --}}
<table>
    <thead>
        <tr>
            <th colspan="5">Tickets generados por usuario</th>
        </tr>
        <tr>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Usuario</th>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Abiertos</th>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Cerrados</th>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">En proceso</th>
            {{-- <th style="background-color: #FF0000; color:white; font-weight: bold;">Vencidos</th> --}}
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tablaUsers as $key=>$user)
            @if ($key<10)    
                <tr>
                    <td>{{$user['user']}}</td>
                    <td>{{$user['abierto']}}</td>
                    <td>{{$user['cerrado']}}</td>
                    <td @if ($user['proceso']>0) style="color:#E26B0A;"  @endif>{{$user['proceso']}}</td>
                    {{-- <td @if ($user['vencido']>0) style="color:#FF0000;"  @endif>{{$user['vencido']}}</td> --}}
                    <td>{{$user['total']}}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
{{-- tabla de fallas --}}
<table>
    <thead>
        <tr>
            <th colspan="5">Tickets por falla</th>
        </tr>
        <tr>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Falla</th>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Abiertos</th>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Cerrados</th>
            <th style="background-color: #FF0000; color:white; font-weight: bold;">En proceso</th>
            {{-- <th style="background-color: #FF0000; color:white; font-weight: bold;">Vencidos</th> --}}
            <th style="background-color: #FF0000; color:white; font-weight: bold;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tablaFallas as $key=>$falla)
            @if ($key<10)    
                <tr>
                    <td>{{$falla['falla']}}</td>
                    <td>{{$falla['abierto']}}</td>
                    <td>{{$falla['cerrado']}}</td>
                    <td @if ($falla['proceso']>0) style="color:#E26B0A;"  @endif>{{$falla['proceso']}}</td>
                    {{-- <td @if ($falla['vencido']>0) style="color:#FF0000;"  @endif>{{$falla['vencido']}}</td> --}}
                    <td>{{$falla['total']}}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>