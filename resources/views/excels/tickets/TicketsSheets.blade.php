<table>
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('ESTADO') }}</th>
            <th>{{ __('DEPARTAMENTO') }}</th>
            <th>{{ __('ÁREA') }}</th>
            <th>{{ __('SERVICIO') }}</th>
            <th>{{ __('FALLA') }}</th>
            <th>{{ __('FECHA CREACIÓN') }}</th>
            <th>{{ __('FECHA VENCIMIENTO') }}</th>
            <th>{{ __('FECHA CERRADO') }}</th>
            <th>{{ __('AGENTE') }}</th>
            <th>{{ __('CLIENTE') }}</th>
            <th>{{ __('PRIORIDAD') }}</th>
            <th>{{ __('TIEMPO ESTIMADO') }}</th>
            <th>{{ __('TIEMPO TOTAL') }}</th>
            <th>{{ __('TIEMPO TAREAS') }}</th>
            <th>{{ __('TIEMPO EFECTIVO') }}</th>
            <th>{{ __('NIVEL DE SERVICIO') }}</th>
            <th>{{ __('HORARIO OFICINA') }}</th>
            <th>{{ __('CLASE TICKET') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tickets as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->status }}
                </td>
                <td>
                    {{$item->falla->servicio->area->departamento->name}}
                </td>
                <td>
                    {{$item->falla->servicio->area->name}}
                </td>
                <td>
                    {{ $item->falla->servicio->name }}
                </td>
                <td>
                    {{$item->falla->name}}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
                <td>
                    {{ $item->fecha_cierre }}
                </td>
                <td>
                    {{ $item->cerrado }}
                </td>
                <td>
                    {{ $item->agente->name }}
                </td>
                <td>
                    {{ $item->cliente->name }}
                </td>
                <td>
                    {{ $item->falla->prioridad->name }}
                </td>
                <td>
                    {{ $item->falla->prioridad->tiempo }}
                </td>
                <td>
                    {{number_format($item->tiempo_total,2)}}
                </td>
                <td>
                    {{$item->tiempo_tarea}}
                </td>
                <td>
                    {{$item->status=='Cerrado'?$item->tiempo_efectivo:0}}
                </td>
                <td>
                    {{$item->status=='Cerrado'?$item->nivel_servicio:''}}
                </td>
                <td>{{$item->oficina}}</td>
                <td>{{$item->falla->prioridad->clase->name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>