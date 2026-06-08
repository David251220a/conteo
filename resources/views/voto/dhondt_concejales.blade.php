<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>D'Hondt Concejales</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
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

        h4 {
            margin-top: 18px;
            margin-bottom: 6px;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
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
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            background: #f2f2f2;
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

    <div class="titulo">D'HONDT - CONCEJALES</div>
    @php
        $desc ='';
        if($general->tipo_votacion == 1){
            $desc ='INTERNA INTENDENTE';
        }
        if($general->tipo_votacion == 2){
            $desc ='GENERALES INTENDENTE';
        }
        if($general->tipo_votacion == 3){
            $desc ='INTERNA PRESIDENCIALES';
        }
        if($general->tipo_votacion == 4){
            $desc ='GENERAL PRESIDENCIALES';
        }
    @endphp
    <div class="subtitulo">
        Escaños a distribuir: <strong>{{ $cantidad_escanos }}</strong><br>
        Año: <strong>{{ $general->anio }}</strong> |
        Tipo votación: <strong>{{ $general->tipo_votacion }}</strong>
    </div>

    <h4>Votos por Lista</h4>

    <table>
        <thead>
            <tr>
                <th>Lista</th>
                <th width="20%">Votos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listas as $item)
                <tr>
                    <td>{{ $item->lista }}</td>
                    <td class="text-right">{{ number_format($item->total_votos, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total">
                <td>Total</td>
                <td class="text-right">{{ number_format($listas->sum('total_votos'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <h4>Escaños Ganadores</h4>

    <table>
        <thead>
            <tr>
                <th>Lista</th>
                <th width="20%">Escaños</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resumenEscanos as $item)
                <tr>
                    <td>{{ $item['lista'] }}</td>
                    <td class="text-center">{{ $item['escanos'] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total">
                <td>Total Escaños</td>
                <td class="text-center">{{ $resumenEscanos->sum('escanos') }}</td>
            </tr>
        </tfoot>
    </table>

    <h4>Candidatos Electos</h4>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="10%">Lista</th>
                <th width="10%">Opcion</th>
                <th>Candidato</th>
                <th width="10%">Votos</th>
                {{-- <th width="10%">Divisor</th>
                <th width="10%">Cociente</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse ($electos as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $item->lista->descripcion ?? '' }}</td>
                    <td class="text-center">{{ $item->orden }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td class="text-right">{{ number_format($item->total_votos, 0, ',', '.') }}</td>
                    {{-- <td class="text-right">{{ $item->divisor  }}</td>
                    <td class="text-right">{{ number_format($item->cociente, 2, ',', '.') }}</td> --}}
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Sin candidatos electos.</td>
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
