<table>
    <thead>
        <tr>
            <th>Agente</th>
            <th>Abiertos</th>
            <th>En proceso</th>
            <th>Cerrados</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tabla as $item)
            <tr>
                <td>{{$item['us']}}</td>
                <td>{{$item['datos']['abierto']}}</td>
                <td @if ($item['datos']['proceso']>0) style="color:#E26B0A;"  @endif>{{$item['datos']['proceso']}}</td>
                <td>{{$item['datos']['cerrado']}}</td>
                <td>{{$item['datos']['total']}}</td>
            </tr>
        @endforeach
        <tr>
            <td style="background-color: #404040; color:white; font-weight: bold;">TOTAL GENERAL</td>
            <td style="background-color: #404040; color:white; font-weight: bold;">{{$totales['abiertos']}}</td>
            <td style="background-color: #404040; color:white; font-weight: bold;">{{$totales['proceso']}}</td>
            <td style="background-color: #404040; color:white; font-weight: bold;">{{$totales['cerrados']}}</td>
            <td style="background-color: #404040; color:white; font-weight: bold;">{{$totales['totGral']}}</td>
        </tr>
    </tbody>
</table>