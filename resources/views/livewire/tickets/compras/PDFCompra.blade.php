<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ mb_strtoupper($nombre) }}</title>
    <style>
        .grid-container {
            width: 1000px;
        }

        .grid-item {
            display: inline-block;
            width: 400px;
            vertical-align: middle;
        }

        .text-dark {
            color: #000;
        }

        .isTable {
            width: 360px;
            font-weight: bold;
            border: 2px solid #8d0505;
        }

        .isTable>tbody>tr {
            border: 2px solid #CC0000;
        }

        .isSecondTable {
            width: 300px;
        }

        .isRed {
            background-color: #8d0505;
            color: #fff;
            margin: 2px;
            padding: 2px;
            width: 120px;
        }

        .isTirdTable {
            border: 2px solid #8d0505;
            width: 100%;
            font-size: 13px;
            border-collapse: collapse;
        }

        .isTirdTable>thead {
            width: 100%;
            border: 2px solid #8d0505;
        }

        .isTirdTable>thead>tr>th {
            border: 2px solid #CC0000;
            text-align: center;
            background-color: #8d0505;
            color: #fff;
            margin: 2px;
            padding: 2px;
        }

        .isTirdTable>tbody {
            border: 2px solid #CC0000;
            text-align: center;
        }

        .isTirdTable>tbody>tr>td {
            margin: 4px;
            padding: 4px;
            font-size: 12px;
            border: 2px solid #8d0505;
            font-weight: bold;
        }

        .motivo {
            margin: 4px;
            padding: 4px;
            font-size: 12px;
            border: 2px solid #CC0000;
            font-weight: bold;
        }

        .motiv {
            background-color: #CC0000;
            color: #fff;
            padding: 2px;
        }
    </style>
</head>

<body>

    <table style="width: 100%">
        <thead>
            <tr>
                <th class="text-left">
                    <img src="{{ public_path('img/logo/FullGas_rojo2.png') }}" alt="" style="width: 150px;">
                </th>
                <th class="text-left text-dark">
                    <h4>
                        {{ __('REQUISICIÓN DE ') . mb_strtoupper($categoria) }}
                    </h4>
                </th>
                <th class="text-right text-dark">

                </th>
            </tr>
        </thead>
    </table>

    <br><br><br>

    <div class="grid-container">
        <div class="grid-item">
            <table class="isTable table-bordered">
                <tbody>
                    <tr>
                        <td class="isRed">
                            {{ __('Departamento:') }}
                        </td>
                        <td class="text-center text-dark">
                            {{ __('SISTEMAS') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="isRed">
                            {{ __('Fecha:') }}
                        </td>
                        <td class="text-center text-dark">
                            {{ $compra->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <td class="isRed">
                            {{ __('Agente:') }}
                        </td>
                        <td class="text-center text-dark">
                            {{ strtoupper($compra->ticket->agente->name) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="isRed">
                            {{ __('Cliente:') }}
                        </td>
                        <td class="text-center text-dark">
                            {{ strtoupper($compra->ticket->cliente->name) }}
                        </td>
                    </tr>
                    {{-- <tr>
                        <td class="isRed">
                            {{ __('Área del cliente:') }}
                        </td>
                        <td class="text-center text-dark">
                            cliente
                        </td>
                    </tr> --}}
                    <tr>
                        <td class="isRed">
                            {{ __('Ticket') }}
                        </td>
                        <td class="text-center text-dark">
                            {{ $compra->ticket_id }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="grid-item">
            <table class="isSecondTable">
                <tbody>
                    <tr>
                        <td class="text-right">
                            <img src="{{ public_path('img/logo/AbejaFullGas.png') }}" alt=""
                                style="width: 250px">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="table-responsive">
        <table class="isTirdTable table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Imagen</th>
                    <th style="width: 70%;">Producto</th>
                    <th>Ud.</th>
                    <th>Cant.</th>
                    <th>Prioridad</th>
                </tr>
            </thead>
            <tbody>
                @if ($compra->productos->count() > 0)
                    @foreach ($compra->productos as $item)
                        <tr>
                            <td class="text-dark">
                                {{ $item->producto->id }}
                            </td>
                            <td>
                                <img src="{{ public_path('storage/' . $item->producto->product_photo_path) }}"
                                    alt="" style="width: 60px">
                            </td>
                            <td class="text-left text-dark">
                                {{ $item->producto->name }}
                            </td>
                            <td class="text-dark">
                                {{ $item->producto->unidad }}
                            </td>
                            <td class="text-dark">
                                {{ $item->cantidad }}
                            </td>
                            <td class="text-dark">
                                {{ $item->producto->prioridad }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    @foreach ($compra->servicios as $item)
                        <tr>
                            <td class="text-dark">
                                {{ $item->servicio->id }}
                            </td>
                            <td>
                                
                            </td>
                            <td class="text-left text-dark">
                                {{ $item->servicio->name }}
                            </td>
                            <td class="text-dark">

                            </td>
                            <td class="text-dark">
                                {{ $item->cantidad }}
                            </td>
                            <td class="text-dark">
                                {{ $item->servicio->prioridad }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <br>
    <div>
        <label for="motivo" class="motiv">Observaciones</label>
        <div class="motivo">
            {{ $compra->problema }}
        </div>
    </div>
	 <br>
    @if (isset($compra->mensaje_opcion))
    <div>
        <label for="motivo" class="motiv">Nota:
        </label>
        <div class="motivo">
            {{ $compra->mensaje_opcion }}
        </div>
    </div>
    @endif
</body>

</html>
