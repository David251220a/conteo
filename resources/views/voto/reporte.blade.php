<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Votos</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .titulo {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .subtitulo {
            text-align: center;
            font-size: 12px;
            margin-bottom: 15px;
        }

        .filtros {
            margin-bottom: 12px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #e9ecef;
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-weight: bold;
        }

        td {
            border: 1px solid #000;
            padding: 5px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total {
            font-weight: bold;
            font-size: 13px;
            background: #f2f2f2;
        }

        .footer {
            position: fixed;
            bottom: 5px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
        }
    </style>
</head>
<body>

    <div class="titulo">REPORTE DE VOTOS</div>

    <div class="subtitulo">
        {{ strtoupper($tipo_reporte ?? 'GENERAL') }}
    </div>
    @php
        $tipo_vot = '';
        if ($general->tipo_votacion == 1) {
            $tipo_vot = 'INTERNA INTENDENTE/CONSEJAL';
        }
        if ($general->tipo_votacion == 2) {
            $tipo_vot = 'GENERAL INTENDENTE/CONSEJAL';
        }
        if ($general->tipo_votacion == 3) {
            $tipo_vot = 'INTERNA PRESIDENCIA';
        }
        if ($general->tipo_votacion == 4) {
            $tipo_vot = 'GENERAL PRESIDENCIA';
        }
    @endphp
    <div class="filtros">
        <strong>Tipo candidato:</strong> {{ $tipo_candidato_descripcion ?? '' }} <br>
        <strong>Local:</strong> {{ $local_descripcion ?? 'TODOS' }} <br>
        <strong>Año:</strong> {{ $general->anio ?? '' }} |
        <strong>Tipo votación:</strong> {{ $tipo_vot ?? '' }}
    </div>

    <table>
        <thead>
            <tr>
                @if (($tipo_reporte ?? 'general') == 'local')
                    <th>Local</th>
                @endif

                @if (($tipo_reporte ?? 'general') == 'mesa')
                    <th>Local</th>
                    <th>Mesa</th>
                @endif

                <th>Lista</th>

                @if (($tipo_reporte ?? 'general') != 'lista')
                    <th>Candidato</th>
                @endif

                <th>Total Votos</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $item)
                <tr>
                    @if (($tipo_reporte ?? 'general') == 'local')
                        <td>{{ $item->local }}</td>
                    @endif

                    @if (($tipo_reporte ?? 'general') == 'mesa')
                        <td>{{ $item->local }}</td>
                        <td class="text-center">{{ $item->mesa }}</td>
                    @endif

                    <td>{{ $item->lista }}</td>

                    @if (($tipo_reporte ?? 'general') != 'lista')
                        <td>{{ $item->nombre }}</td>
                    @endif

                    <td class="text-right">
                        {{ number_format($item->total_votos, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            @php
                $colspan = 2;

                if (($tipo_reporte ?? 'general') == 'local') {
                    $colspan = 3;
                }

                if (($tipo_reporte ?? 'general') == 'mesa') {
                    $colspan = 4;
                }

                if (($tipo_reporte ?? 'general') == 'lista') {
                    $colspan = 1;
                }
            @endphp

            <tr class="total">
                <td colspan="{{ $colspan }}">TOTAL GENERAL</td>
                <td class="text-right">
                    {{ number_format($data->sum('total_votos'), 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
