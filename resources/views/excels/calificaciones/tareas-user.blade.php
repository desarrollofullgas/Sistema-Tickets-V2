<table>
    <thead>
        <tr>
            <th></th>
            <th>Abierto</th>
            <th>En proceso</th>
            <th>Cerrado</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tabla as $user)
            <tr>
                <td>{{$user['name']}}</td>
                <td>{{$user['abierto']}}</td>
                <td>{{$user['proceso']}}</td>
                <td>{{$user['cerrado']}}</td>
                <td>{{$user['totales']}}</td>
            </tr>
        @endforeach
        <tr>
            <td  style="background-color: #404040; color:white; font-weight: bold;">TOTAL GENERAL</td>
            <td  style="background-color: #404040; color:white; font-weight: bold;">{{$totales['abierto']}}</td>
            <td  style="background-color: #404040; color:white; font-weight: bold;">{{$totales['proceso']}}</td>
            <td  style="background-color: #404040; color:white; font-weight: bold;">{{$totales['cerrado']}}</td>
            <td  style="background-color: #404040; color:white; font-weight: bold;">{{$totales['totales']}}</td>
        </tr>
    </tbody>
</table>