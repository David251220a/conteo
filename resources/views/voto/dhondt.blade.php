@extends('layouts.admin')

@section('content')

<div class="col-lg-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">

            <h3>
                D’HONDT - CONCEJALES - <a href="{{route('voto.reporte_dhondt_concejales')}}" target="__blank" style="font-size: 30px;color: red"><i class="fas fa-file-pdf"></i></a>
            </h3>
            <p><b>Escaños a distribuir:</b> {{ $cantidad_escanos }}</p>

            <h5>Votos por Lista</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Lista</th>
                        <th class="text-right">Votos</th>
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
            </table>

            <hr>

            <h5>Escaños Ganadores</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Lista</th>
                        <th class="text-right">Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resumenEscanos as $item)
                        <tr>
                            <td>{{ $item['lista'] }}</td>
                            <td class="text-right">{{ number_format($item['escanos'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            <h5>Candidatos Electos</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Lista</th>
                        <th class="text-center">Orden</th>
                        <th>Candidato</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @forelse ($electos as $item)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{ $item->lista->descripcion ?? '' }}</td>
                            <td class="text-center">{{ $item->orden }}</td>
                            <td>{{ $item->nombre }}</td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Sin candidatos electos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection
