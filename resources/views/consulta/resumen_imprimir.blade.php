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

    <div class="titulo">
        {{ $reporte == 1 ? 'RESUMEN POR REFERENTE' : 'RESUMEN POR MÓVIL' }}
    </div>

    <div class="subtitulo">
        Año: <strong>{{ $general->anio }}</strong> |
        Tipo votación: <strong>{{ $general->tipo_votacion }}</strong><br>

        @if(request('local_id') > 0)
            Local:
            <strong>{{ $descripcionLocal->descripcion }}</strong><br>
        @endif
    </div>

    @if ($reporte == 1)
        <table>
            <thead>
                <tr>
                    <th>Referente</th>
                    <th class="text-center">Vehículos</th>
                    <th class="text-center">Votantes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->referente }}</td>
                        <td style="text-align: right">{{ $item->total_vehiculos }}</td>
                        <td style="text-align: right">{{ $item->total_votantes }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Total</td>
                    <td style="text-align: right">{{ $data->sum('total_votantes') }}</td>
                </tr>
            </tfoot>
        </table>
    @else
        <table>
            <thead>
                <tr>
                    <th>Referente</th>
                    <th>Móvil</th>
                    <th class="text-center">Votantes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->referente }}</td>
                        <td style="text-align: right">{{ $item->vehiculo }}</td>
                        <td style="text-align: right">{{ $item->total_votantes }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Total</td>
                    <td style="text-align: right">{{ $data->sum('total_votantes') }}</td>
                </tr>
            </tfoot>
        </table>
    @endif

    <div class="footer">
        <div>Equipo Técnico de Manuel Aguilar</div>
        <div>Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

</body>
</html>
