<table>
    <thead>
        <tr>
            <th>No.Tarea</th>
            <th>Ticket</th>
            <th>Estado</th>
            <th>Fecha de creación</th>
            <th>Fecha de cierre</th>
            <th>Creado por</th>
            <th>Asignado a</th>
            <th>Solución (hrs)</th>
            <th>Mensaje</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tareas as $tarea)
            <tr>
                <td>{{$tarea->id}}</td>
                <td>{{$tarea->ticket_id}}</td>
                <td>
                    @if ($tarea->deleted_at==null)
                        {{$tarea->status}}
                    @else
                        Borrado
                    @endif
                </td>
                <td>{{$tarea->created_at}}</td>
                <td>{{$tarea->fecha_cierre}}</td>
                <td>{{$tarea->usercrea->name}}</td>
                <td>{{$tarea->user->name}}</td>
                <td>{{number_format($tarea->solucion,2)}}</td>
                <td>{{$tarea->mensaje}}</td>
            </tr>
        @endforeach
    </tbody>
</table>