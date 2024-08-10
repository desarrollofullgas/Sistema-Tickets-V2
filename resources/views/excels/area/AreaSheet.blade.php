<table>
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('NOMBRE') }}</th>
            <th>{{ __('DEPARTAMENTO') }}</th>
            <th>{{ __('ESTADO') }}</th>
            <th>{{ __('FECHA') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($areas as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->name }}
                </td>
                <td>
                    {{ $item->departamento->name }}
                </td>
                <td>
                    {{ $item->status}}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>