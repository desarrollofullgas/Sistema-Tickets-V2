<table>
    <thead>
        <tr>
            <th>Tipo de compra</th>
            <th>Zona</th>
            <th>Estacion</th>
            <th>Producto</th>
            <th>Cantidad Solicitada</th>
            <th>Subtotal</th>
            <th>I.V.A</th>
            <th>ISR</th>
            <th>Total</th>
            <th>Categoría</th>
            <th>Proveedor</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $d)
            @if ($d->tipo_compra == "Ordinario")    
                @foreach ($d->productos as $p)
                    <tr>
                        <th>{{$d->tipo_compra}}</th>
                        <th>{{$d->estacion->zona->name}}</th>
                        <th>{{$d->estacion->name}}</th>
                        <th>{{$p->name}}</th>
                        @foreach ($cantP as $c)
                            @if ($c->solicitud_id==$d->id && $p->id==$c->producto_id)
                                <th>{{$c->cantidad}}</th>
                                <th>{{($p->precio - ($p->precio * 0.16))*$c->cantidad}}</th>
                                <th>{{($p->precio * 0.16)* $c->cantidad}}</th>
                                <th></th>
                                <th>{{$p->precio * $c->cantidad}}</th>
                            @endif
                        @endforeach
                        
                        <th>{{$p->categoria->name}}</th>
                        @foreach ($proveedor as $pro)
                            @if ($pro->id==$d->id && $p->id==$pro->producto_id)
                                <th>{{$pro->titulo_proveedor}}</th>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                @foreach ($total as $t)
                    @if ($t->solicitud_id == $d->id)
                        <tr>
                            <th colspan="5" style="background-color:#4b4b4b;color:white;">TOTAL</th>
                            <th style="background-color:#4b4b4b;color:white;">{{($t->total - ($t->total *0.16))}}</th>
                            <th style="background-color:#4b4b4b;color:white;">{{$t->total *0.16}}</th>
                            <th style="background-color:#4b4b4b;color:white;"></th>
                            <th style="background-color:#4b4b4b;color:white;">{{$t->total}}</th>
                        </tr>
                    @endif
                @endforeach
            @else
                    @foreach ($d->extraordinarios as $ex)
                        <tr>
                            <th>{{$d->tipo_compra}}</th>
                            <th>{{$d->estacion->zona->name}}</th>
                            <th>{{$d->estacion->name}}</th>
                            <th>{{$ex->producto_extraordinario}}</th>
                            <th>{{$ex->cantidad}}</th>
                            <th>{{($ex->total - ($ex->total * 0.16))}}</th>
                            <th>{{$ex->total * 0.16}}</th>
                            @if ($ex->tipo=="Servicio")
                                <th>{{($ex->total - ($ex->total * 0.16))*0.0125}}</th>
                                <th>{{($ex->total)-(($ex->total - ($ex->total * 0.16))*0.0125)}}</th>
                            @else
                                <th></th>
                                <th>{{$ex->total}}</th>
                            @endif
                            
                            <th>{{$d->categoria->name}}</th>
                        </tr>
                    @endforeach
                    @foreach ($totalEX as $tEX)
                        @if ($tEX->solicitud_id == $d->id)
                            <tr>
                                <th colspan="5" style="background-color:#4b4b4b;color:white;">TOTAL</th>
                                <th style="background-color:#4b4b4b;color:white;">{{($tEX->total - ($tEX->total *0.16))}}</th>
                                <th style="background-color:#4b4b4b;color:white;">{{$tEX->total *0.16}}</th>
                                @if ($tEX->isr > 0)
                                    <th style="background-color:#4b4b4b;color:white;">{{$tEX->isr}}</th>
                                @else
                                    <th style="background-color:#4b4b4b;color:white;"></th>    
                                @endif
                                <th style="background-color:#4b4b4b;color:white;">{{$tEX->total - $tEX->isr}}</th>
                            </tr>
                        @endif
                    @endforeach
            @endif
            
        @endforeach
    </tbody>
</table>