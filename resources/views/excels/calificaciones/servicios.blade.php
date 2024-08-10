{{-- @foreach ($tablas as $tabla)
    <table>
        <thead>
            <tr>
                <th colspan="6">{{$tabla['serv']}}</th>
            </tr>
            <tr>
                <th style="background-color: #800000; color:white; font-weight: bold; text-align:center">FALLA</th>
                <th style="background-color: #800000; color:white; font-weight: bold; text-align:center">ABIERTOS</th>
                <th style="background-color: #800000; color:white; font-weight: bold; text-align:center">EN PROCESO</th>
                <th style="background-color: #800000; color:white; font-weight: bold; text-align:center">CERRADOS</th>
                <th style="background-color: #800000; color:white; font-weight: bold; text-align:center">VENCIDOS</th>
                <th style="background-color: #800000; color:white; font-weight: bold; text-align:center">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tabla['fallas'] as $item)
                <tr>
                    <td>{{$item['falla']}}</td>
                    <td>{{$item['datos']['abierto']}}</td>
                    <td>{{$item['datos']['proceso']}}</td>
                    <td>{{$item['datos']['cerrado']}}</td>
                    <td>{{$item['datos']['vencido']}}</td>
                    <td>{{$item['datos']['total']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach --}}
<table>
    <thead>
        <tr>
            <th>Servicio</th>
            <th>Falla</th>
            <th>Abierto</th>
            <th>En proceso</th>
            {{-- <th>Vencidos</th> --}}
            <th>Cerrados</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tablas as $tabla)
            <tr>
                <td rowspan="{{count($tabla['fallas'])}}">{{$tabla['serv']}}</td>
                <td>{{$tabla['fallas'][0]['falla']}}</td>
                <td>{{$tabla['fallas'][0]['datos']['abierto']}}</td>
                <td @if ($tabla['fallas'][0]['datos']['proceso']>0) style="color:#E26B0A;" @endif>{{$tabla['fallas'][0]['datos']['proceso']}}</td>
                {{-- <td @if ($tabla['fallas'][0]['datos']['vencido']>0) style="color:#FF0000;" @endif>{{$tabla['fallas'][0]['datos']['vencido']}}</td> --}}
                <td>{{$tabla['fallas'][0]['datos']['cerrado']}}</td>
                <td>{{$tabla['fallas'][0]['datos']['total']}}</td>
            </tr>
            @foreach ($tabla['fallas'] as $key => $item)
                @if ($key !=0)    
                    <tr>
                        <td>{{$item['falla']}}</td>
                        <td>{{$item['datos']['abierto']}}</td>
                        <td>{{$item['datos']['proceso']}}</td>
                        {{-- <td>{{$item['datos']['vencido']}}</td> --}}
                        <td>{{$item['datos']['cerrado']}}</td>
                        <td>{{$item['datos']['total']}}</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="2" style="background-color: #404040; color:white; font-weight: bold;"> TOTAL DEL SERVICIO {{$tabla['serv']}}</td>
                <td style="background-color: #404040; color:white; font-weight: bold;">{{$tabla['totales']['abiertos']}}</td>
                <td style="background-color: #404040; color:white; font-weight: bold;">{{$tabla['totales']['proceso']}}</td>
                <td style="background-color: #404040; color:white; font-weight: bold;">{{$tabla['totales']['cerrados']}}</td>
                <td style="background-color: #404040; color:white; font-weight: bold;">{{$tabla['totales']['totGral']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>