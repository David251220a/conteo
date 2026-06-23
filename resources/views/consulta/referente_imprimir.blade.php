<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Consulta de Referentes</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #000;
            margin-bottom: 45px;
        }

        .titulo {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitulo {
            text-align: center;
            font-size: 12px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            border: 1px solid #000;
            background: #e9ecef;
            padding: 5px;
            text-align: center;
            font-weight: bold;
        }

        td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 8px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <div class="titulo">CONSULTA DE REFERENTES</div>

    <div class="subtitulo">
        Año: <strong>{{ $general->anio }}</strong> |
        Tipo votación: <strong>{{ $general->tipo_votacion }}</strong><br>

        @if(request('local_id') > 0)
            Local:
            <strong>{{ $descripcionLocal->descripcion }}</strong><br>
        @endif

        @if(request('referente_id') > 1)
            Referente:
            <strong>{{ optional($data->first()?->refe)->referente }}</strong><br>
        @endif

        @if(request('movil_id') > 0)
            Móvil:
            <strong>{{ optional($data->first()?->Vehiculo)->nombre }}</strong><br>
        @endif

        Total registros: <strong>{{ $data->count() }}</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th width="9%">Documento</th>
                <th width="22%">Nombre y Apellido</th>
                <th width="22%">Local</th>
                <th width="8%">Mesa</th>
                <th width="8%">Orden</th>

                @if(request('referente_id') <= 1)
                    <th width="17%">Referente</th>
                @endif

                @if(request('movil_id') <= 0)
                    <th width="14%">Móvil</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr>
                    <td class="text-center">{{ $item->documento }}</td>
                    <td>{{ $item->nombre }} {{ $item->apellido }}</td>
                    <td>{{ $item->local->descripcion }}</td>
                    <td class="text-center">{{ $item->mesa }}</td>
                    <td class="text-center">{{ $item->orden }}</td>

                    @if(request('referente_id') <= 1)
                        <td>{{ $item->refe->referente }}</td>
                    @endif

                    @if(request('movil_id') <= 0)
                        <td>
                            {{ $item->vehiculo_id == 0 ? 'SIN ESPECIFICAR' : $item->Vehiculo->nombre }}
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Sin registros.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div>Equipo Técnico de Manuel Aguilar</div>
        <div>Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

</body>
</html>
