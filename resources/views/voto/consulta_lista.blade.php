@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/elements/alert.css')}}">
    <link href="{{asset('assets/css/elements/infobox.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/tables/table-basic.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div  class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <div class="row align-items-center mb-3">
                    <div class="col-md-6">
                        <h3 class="mb-0">Consulta Votos</h3>
                    </div>
                </div>

                @include('varios.mensaje')

                <form action="{{ route('voto.consulta_lista') }}" method="GET">
                    <div class="row align-items-end">
                        <!-- TIPO CANDIDATO -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tipo_candidato_id">Tipo Candidato</label>
                                <select name="tipo_candidato_id" id="tipo_candidato_id" class="form-control">
                                    @foreach ($tipoCandidato as $item)
                                        <option {{ $tipo_candidato_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                                            {{ $item->descripcion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- MOVIMIENTOS -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="local_id">Local</label>
                                <select name="local_id" id="local_id" class="form-control">
                                    <option value="0">-- Todos --</option>
                                    @foreach ($locales as $item)
                                        <option {{ request('local_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                                            {{ $item->descripcion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tipo_reporte">Tipo Reporte</label>
                                <select name="tipo_reporte" id="tipo_reporte" class="form-control">
                                    <option {{ request('tipo_reporte') == 'general' ? 'selected' : '' }} value="general">GENERAL</option>
                                    <option {{ request('tipo_reporte') == 'local' ? 'selected' : '' }} value="local">LOCAL</option>
                                    <option {{ request('tipo_reporte') == 'mesa' ? 'selected' : '' }} value="mesa">MESA</option>
                                    <option {{ request('tipo_reporte') == 'lista' ? 'selected' : '' }} value="lista">LISTA</option>
                                </select>
                            </div>
                        </div>

                        <!-- BOTON -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger w-40">
                                    <i class="fa fa-search"></i> Buscar
                                </button>
                                <a href="{{route('voto.reporte', request()->all())}}" target="__blank" style="font-size: 30px;color: red"><i class="fas fa-file-pdf"></i></a>
                            </div>
                        </div>

                    </div>
                </form>

                <div class="row mt-1">
                    <div  class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-checkable table-highlight-head mb-4">
                                <thead>
                                    <tr>
                                        @if (request('tipo_reporte') == 'local')
                                            <th>Local</th>
                                        @endif
                                        @if (request('tipo_reporte') == 'mesa')
                                            <th>Local</th>
                                            <th>Mesa</th>
                                        @endif
                                        <th class="">Lista</th>
                                        @if (request('tipo_reporte') <> 'lista')
                                            <th class="">Candidato</th>
                                        @endif
                                        <th class="text-center" width="10%">Total Voto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            @if (request('tipo_reporte') == 'local')
                                                <td>{{$item->local}}</td>
                                            @endif
                                            @if (request('tipo_reporte') == 'mesa')
                                                <td>{{$item->local}}</td>
                                                <td class="text-right">{{$item->mesa}}</td>
                                            @endif
                                            <td>{{$item->lista}}</td>
                                            @if (request('tipo_reporte') <> 'lista')
                                                <td>{{$item->nombre}}</td>
                                            @endif
                                            <td class="text-right">{{ number_format($item->total_votos, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        @php
                                            $i = 2;
                                            if(request('tipo_reporte') == 'local'){
                                                $i = 3;
                                            }
                                            if(request('tipo_reporte') == 'mesa'){
                                                $i = 4;
                                            }
                                            if(request('tipo_reporte') == 'lista'){
                                                $i = 1;
                                            }
                                        @endphp
                                        <td colspan="{{$i}}" style="font-weight: bold; font-size:20px">Total General</td>
                                        <td class="text-right" style="font-weight: bold; font-size:20px">{{ number_format($data->sum('total_votos'), 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
@endsection
