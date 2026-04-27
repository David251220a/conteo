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

                <form action="{{ route('voto.consulta_votos_carga') }}" method="GET">
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
                        <!-- MOVIMIENTOS -->
                        <div class="col-md-4">
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
                            <table class="table table-bordered table-hover table-checkable table-highlight-head mb-4">
                                <thead>
                                    <tr>
                                        <th class="">Local</th>
                                        <th class="">Mesa</th>
                                        <th class="text-center" width="10%">Total Voto</th>
                                        <th class="text-center">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{$item->local->descripcion}}</td>
                                            <td>{{$item->mesa}}</td>
                                            <td class="text-right">{{ number_format($item->total_votos, 0, ',', '.') }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" style="font-weight: bold; font-size:20px">Total General</td>
                                        <td colspan="2" class="text-right" style="font-weight: bold; font-size:20px">{{ number_format($totalGeneral, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{ $data->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
@endsection
