<table>
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('NOMBRE') }}</th>
            <th>{{ __('TOTAL GERENTES') }}</th>
            <th>{{ __('TOTAL SUPERVISORES') }}</th>
            <th>{{ __('TOTAL ESTACIONES') }}</th>
            <th>{{ __('FECHA') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($zonas as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->name }}
                </td>
                <td>
                    {{ $item->users->where('permiso_id', 3)->count() }}
                </td>
                <td>
                    {{ $item->users->where('permiso_id', 2)->count() }}
                </td>
                <td>
                    {{ $item->estacions->count() }}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>