<table>
    <thead>
        <tr>
            <th>USUARIO</th>
            <th>PUNTOS POSITIVOS</th>
            <th>PUNTOS NEGATIVOS</th>
            <th>TOTAL DE PUNTOS</th>
            <th>CALIFICACIÓN</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($grupos as $grupo)
            @foreach ($grupo as $user)
                <tr>
                    <td>{{$user['user']}}</td>
                    <td>{{$user['pos']}}</td>
                    <td>{{$user['neg']}}</td>
                    <td>{{$user['total']}}</td>
                    <td>{{number_format($user['cal'],1)}}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>