<table>
    <thead>
        <tr>
            <th>{{ __('TAREA') }}</th>
            <th>{{ __('TICKET') }}</th>
            <th>{{ __('AGENTE') }}</th>
            <th>{{ __('ASIGNADO') }}</th>
            <th>{{ __('ASUNTO') }}</th>
            <th>{{ __('ESTADO') }}</th>
            <th>{{ __('CREADO') }}</th>
            <th>{{ __('ACTUALIZADO') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tareas as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->ticket->id }}
                </td>
                <td>
                    {{ $item->ticket->agente->name}}
                </td>
                <td>
                    {{ $item->user->name }}
                </td>
                <td>
                    {{ $item->asunto }}
                </td>
                <td>
                    {{ $item->status }}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
                <td>
                    {{ $item->updated_at }}
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>