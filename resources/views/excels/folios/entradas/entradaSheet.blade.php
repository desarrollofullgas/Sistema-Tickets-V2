@foreach ($folio as $entrada)        
<table style="border-collapse:collapse;">   
    <thead>
        <tr>
            <th colspan="7">Entrada #{{$entrada->id}}</th>
            
        </tr>
        <tr>
            <th colspan="7">Motivo: {{$entrada->motivo}}</th>
            
        </tr>
        <tr>
            <th>No. de ticket</th>
            <th>Cliente</th>
            <th>Producto</th>
            <th>Serie</th>
            <th>Cantidad</th>
            <th>Observación</th>
            <th>Fecha de registro en el sistema</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($entrada->productos as $producto)
            <tr>
                <th>{{isset($producto->ticket->id)?'#'.$producto->ticket->id : 'S/N'}}</th>
                <th>{{ isset($producto->ticket->cliente->name) ? $producto->ticket->cliente->name : 'S/N' }}
                <th>{{$producto->producto->name}}</th>
                <th>"{{$producto->serie->serie}}"</th>
                <th>{{$producto->cantidad}}</th>
                <th>{{$producto->observacion}}</th>
                <th>{{$producto->created_at}}</th>
            </tr>
        @endforeach
    </tbody>
</table>
@endforeach