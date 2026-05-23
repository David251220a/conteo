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
                        <h3 class="mb-0">Simulacion de Fecha: {{ date('d/m/Y', strtotime($fecha))}}</h3>
                    </div>
                </div>
                <form action="{{ route('consulta.simulacion_ver', $fecha) }}" method="GET">
                    <div class="row align-items-end">

                        <!-- TIPO CANDIDATO -->
                        <div class="col-md-4">
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

                        <!-- BOTON -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-info w-100">
                                    <i class="fa fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>

                    </div>
                </form>

                <div class="row mt-1">
                    <div  class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                                <thead>
                                    <tr>
                                        <th class="">Lista</th>
                                        <th>Nombre</th>
                                        <th>Votos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{$item->lista->descripcion}}</td>
                                            <td>{{$item->candidato->nombre}}</td>
                                            <td class="text-right">{{number_format($item->cantidad, 0, ',', '.')}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th class="text-right">{{ number_format($data->sum('cantidad'), 0, ',', '.') }}</th>
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
