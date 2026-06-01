<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Acta de Votación</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .titulo {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitulo {
            text-align: center;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .info {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .info td {
            padding: 4px;
            font-size: 12px;
        }

        table.resultado {
            width: 100%;
            border-collapse: collapse;
        }

        table.resultado th,
        table.resultado td {
            border: 1px solid #000;
            padding: 6px;
        }

        table.resultado th {
            background: #eaeaea;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .firma {
            margin-top: 60px;
            width: 100%;
        }

        .firma td {
            text-align: center;
            padding-top: 30px;
        }

        .linea {
            border-top: 1px solid #000;
            width: 220px;
            margin: auto;
            padding-top: 5px;
        }
    </style>
</head>
<body>

<div class="titulo">ACTA DE VOTACIÓN</div>
<div class="subtitulo">Resultados cargados por mesa</div>

<table class="info">
    <tr>
        <td><strong>Año:</strong> {{ $data->first()->anio ?? '' }}</td>
        <td><strong>Tipo votación:</strong> {{ $data->first()->tipo_votacion ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Local:</strong> {{ $mesa->local->descripcion ?? '' }}</td>
        <td><strong>Mesa:</strong> {{ $mesa->mesa ?? '' }}</td>
        <td><strong>Tipo candidato:</strong> {{ $tipo->descripcion ?? '' }}</td>
    </tr>
</table>

@if($tipo_candidato_id != 5)

    <table class="resultado">
        <thead>
            <tr>
                <th>Lista</th>
                <th>Opción</th>
                <th>Candidato</th>
                <th>Votos</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
                <tr>
                    <td class="text-center">{{ $item->lista->descripcion ?? '' }}</td>
                    <td class="text-center">
                        @if(($item->candidato->orden ?? 0) >= 97)
                            {{ $item->candidato->nombre ?? '' }}
                        @else
                            {{ $item->candidato->orden ?? '' }}
                        @endif
                    </td>
                    <td>{{ $item->candidato->nombre ?? '' }}</td>
                    <td class="text-right">{{ number_format($item->votos, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No se encontraron votos cargados.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">TOTAL</th>
                <th class="text-right">{{ number_format($data->sum('votos'), 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

@else

    <table class="resultado">
        <thead>
            <tr>
                <th style="width: 15%">Opción</th>
                @foreach($listas as $lista)
                    <th>{{ $lista->descripcion }}</th>
                @endforeach
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach($ordenesNormales as $orden)
                <tr>
                    <td class="text-center">{{ $orden }}</td>

                    @php $totalFila = 0; @endphp

                    @foreach($listas as $lista)
                        @php
                            $cantidad = $matriz[$orden][$lista->id] ?? 0;
                            $totalFila += $cantidad;
                        @endphp

                        <td class="text-right">{{ number_format($cantidad, 0, ',', '.') }}</td>
                    @endforeach

                    <td class="text-right">
                        <strong>{{ number_format($totalFila, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            @endforeach

            @foreach($candidatosEspeciales as $item)
                <tr>
                    <td class="text-center">{{ $item->candidato->nombre ?? '' }}</td>

                    @foreach($listas as $lista)
                        <td class="text-right">
                            @if($item->lista_id == $lista->id)
                                {{ number_format($item->votos, 0, ',', '.') }}
                            @else
                                0
                            @endif
                        </td>
                    @endforeach

                    <td class="text-right">
                        <strong>{{ number_format($item->votos, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <th class="text-right">TOTAL</th>
                @foreach($listas as $lista)
                    <th class="text-right">
                        {{ number_format($data->where('lista_id', $lista->id)->sum('votos'), 0, ',', '.') }}
                    </th>
                @endforeach
                <th class="text-right">{{ number_format($data->sum('votos'), 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

@endif

<table class="firma">
    <tr>
        <td><div class="linea">Firma responsable</div></td>
        <td><div class="linea">Aclaración</div></td>
    </tr>
</table>

</body>
</html>
