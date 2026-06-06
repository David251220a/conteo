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
                                        <th width="15%" class="text-center">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{$item->local->descripcion}}</td>
                                            <td>{{$item->mesa}}</td>
                                            <td class="text-right">{{ number_format($item->total_votos, 0, ',', '.') }}</td>
                                            <td>
                                                {{-- <a href="{{ route('voto.anular_carga_voto', $item) }}" class="btn btn-danger btn-sm">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle>
                                                        <line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>
                                                    </svg>
                                                </a> --}}
                                                <button type="button" class="btn btn-sm btn-danger mr-3" data-toggle="modal" data-target="#carga_{{ $item->id }}">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle>
                                                        <line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>
                                                    </svg>
                                                </button>

                                                <a href="{{ route('voto.impresion_acta', [$item->id, $item->tipo_cantidato_id]) }}" target="__blank" class="btn btn-info btn-sm">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </a>
                                                @include('voto.modal_anulacion')
                                            </td>
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
