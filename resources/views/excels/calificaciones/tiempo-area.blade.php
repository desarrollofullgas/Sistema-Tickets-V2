@foreach ($tablas as $tabla)
    <table>
        <thead>
            <tr>
                <th rowspan="4">{{$tabla['area']}}</th>
                <th style="background-color: #FF0000; color:white; font-weight: bold;"></th>
                <th style="background-color: #FF0000; color:white; font-weight: bold;">BAJO</th>
                <th style="background-color: #FF0000; color:white; font-weight: bold;">MEDIO</th>
                <th style="background-color: #FF0000; color:white; font-weight: bold;">ALTO</th>
                <th style="background-color: #FF0000; color:white; font-weight: bold;">CRÍTICO</th>
                <th style="background-color: #FF0000; color:white; font-weight: bold;">ALTO CRÍTICO</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tabla['data'] as $kt=> $tipo)
                <tr>
                    <td>{{$kt}}</td>
                    @foreach ($tipo as $prioridad)
                        <td>{{$prioridad['cant']>0?number_format(($prioridad['suma']/$prioridad['cant']),2):0}}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach