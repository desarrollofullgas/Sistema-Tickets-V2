<table>
    <thead>
        <tr>
            <th>{{ __('NO. ESTACIÓN') }}</th>
            <th>{{ __('ESTACIÓN') }}</th>
            <th>{{ __('GERENTE') }}</th>
            <th>{{ __('SUPERVISOR') }}</th>
            <th>{{ __('ZONA') }}</th>
            <th>{{ __('FECHA') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($estaciones as $item)
            <tr>
                <td>
                    {{ $item->num_estacion }}
                </td>
                <td>
                    {{ $item->name }}
                </td>
                <td>
                    @if ($item->user_id == null)
                        {{ __('Sin Gerente') }}
                    @else
                        {{ $item->user->name }}
                    @endif
                </td>
                <td>
                    @if ($item->supervisor_id == null)
                        {{ __('Sin Supervisor') }}
                    @else
                        {{ $item->supervisor->name }}
                    @endif
                </td>
                <td>
                    {{ $item->zona->name }}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>