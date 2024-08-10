<table>
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('TICKET') }}</th>
            <th>{{ __('AGENTE') }}</th>
            <th>{{ __('CLIENTE') }}</th>
            <th>{{ __('ESTADO') }}</th>
            <th>{{ __('SOLICITADO') }}</th>
            <th>{{ __('ACTUALIZADO') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($compras as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->ticket_id }}
                </td>
                <td>
                    {{ $item->ticket->agente->name}}
                </td>
                <td>
                    {{ $item->ticket->cliente->name }}
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