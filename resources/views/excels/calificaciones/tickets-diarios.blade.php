<table>
    <thead>
        <tr>
            <th>Día</th>
            <th>Abiertos</th>
            <th>En proceso</th>
            {{-- <th>Vencidos</th> --}}
            <th>Cerrados</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $item)
            <tr>
                <td>{{$item['dia']}}</td>
                <td>{{$item['abierto']}}</td>
                <td @if ($item['proceso']>0) style="color:#E26B0A;"  @endif>{{$item['proceso']}}</td>
                {{-- <td @if ($item['vencido']>0) style="color:#FF0000;"  @endif>{{$item['vencido']}}</td> --}}
                <td>{{$item['cerrado']}}</td>
                <td>{{$item['total']}}</td>
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