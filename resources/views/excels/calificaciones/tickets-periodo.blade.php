<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Agente</th>
            <th>Cliente</th>
            <th>Departamento</th>
            <th>Área</th>
            <th>Servicio</th>
            <th>Falla</th>
            <th>Fecha de creación</th>
            <th>Fecha de vencimiento</th>
            <th>Fecha de cierre</th>
            <th>Tiempo estimado ( hrs )</th>
            <th>Tiempo total ( hrs )</th>
            <th>Tiempo tareas ( hrs )</th>
            <th>Tiempo efectivo ( hrs )</th>
            <th>Estado</th>
            <th>Prioridad</th>
            <th>Nivel de servicio</th>
            <th>Horario de oficina</th>
            <th>Clase ticket</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tcks as $tck)    
            <tr>
                <td>{{$tck->id}}</td>
                <td>{{$tck->agente->name}}</td>
                <td>{{$tck->cliente->name}}</td>
                <td>{{$tck->falla->servicio->area->departamento->name}}</td>
                <td>{{$tck->falla->servicio->area->name}}</td>
                <td>{{$tck->falla->servicio->name}}</td>
                <td>{{$tck->falla->name}}</td>
                <td>{{$tck->created_at}}</td>
                <td>{{$tck->fecha_cierre}}</td>
                <td>{{$tck->cerrado}}</td>
                <td>{{$tck->falla->prioridad->tiempo}}</td>
                <td>{{number_format($tck->tiempo_total,2)}}</td>
                <td>{{$tck->tiempo_tarea}}</td>
                <td>{{$tck->status=='Cerrado'?$tck->tiempo_efectivo:0}}</td>
                <td>{{$tck->status=='Vencido'?'En proceso':$tck->status}}</td>
                <td>{{$tck->falla->prioridad->name}}</td>
                <td>{{$tck->status=='Cerrado'?$tck->nivel_servicio:''}}</td>
                <td>{{$tck->oficina}}</td>
                <td>{{$tck->falla->prioridad->clase->name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>