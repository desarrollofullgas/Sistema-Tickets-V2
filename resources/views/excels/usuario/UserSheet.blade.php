<table>
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('NOMBRE') }}</th>
            <th>{{ __('ROL') }}</th>
            <th>{{ __('ZONAS') }}</th>
            <th>{{ __('ÁREAS') }}</th>
            <th>{{ __('ESTADO') }}</th>
            <th>{{ __('FECHA') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->name }}
                </td>
                <td>
                    {{ $item->permiso->titulo_permiso }}
                </td>
                <td>
                    @foreach($item->zonas as $zona)
                    {{ $zona->name }}
                    @endforeach
                </td>
                <td>
                    @foreach($item->areas as $area)
                    {{ $area->name }}
                    @endforeach
                </td>
                <td>
                    {{ $item->status }}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>