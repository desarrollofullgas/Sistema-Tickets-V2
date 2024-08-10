<table>
    <thead>
        <tr>
            <th>No. de ticket</th>
            <th>Cliente</th>
            <th>Producto</th>
            <th>Serie</th>
            <th>Cantidad</th>
            <th>Usuario</th>
            <th>Observación</th>
            <th>Fecha de registro</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($folio->salidas as $salida)
            @foreach ($salida->productos as $producto)
                <tr>
                    <th>{{isset($producto->ticket->id)?$producto->ticket->id : 'S/N'}}</th>
                    <th>{{ isset($producto->ticket->cliente->name) ? $producto->ticket->cliente->name : 'S/N' }}
                    <th>{{$producto->producto->name}}</th>
                    <th>"{{$producto->serie->serie}}"</th>
                    <th>{{$producto->cantidad}}</th>
                    <th>{{$salida->usuario->name}}</th>
                    <th>{{$producto->observacion}}</th>
                    <th>{{$producto->created_at}}</th>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>