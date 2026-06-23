@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/elements/alert.css')}}">
    <link href="{{asset('assets/css/elements/infobox.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/tables/table-basic.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.min.css')}}">
@endsection

@section('content')

    <div  class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <div class="row align-items-center mb-3">
                    <div class="col-md-6">
                        <h3 class="mb-0">Resumen Referentes</h3>
                    </div>
                </div>

                <form action="{{route('consulta.resumen')}}" method="GET">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-row mb-2">
                                <div class="form-group col-md-3">
                                    <label for="local_id">Local</label>
                                    <select name="local_id" id="local_id" class="form-control">
                                        @foreach ($locales as $item)
                                            <option {{ request('local_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                                                {{ $item->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="reporte">Tipo Reporte</label>
                                    <select name="reporte" id="reporte" class="form-control">
                                        <option {{ request('reporte') == 1 ? 'selected' : '' }} value="1">
                                            Referente
                                        </option>
                                        <option {{ request('reporte') == 2 ? 'selected' : '' }} value="2">
                                            Movil
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3 d-flex align-items-center">
                                    <button type="submit" class="btn btn-danger mr-2">
                                        <i class="fa fa-search"></i> Buscar
                                    </button>

                                    <a href="{{ route('consulta.resumen.imprimir', request()->query()) }}" target="__blank"
                                        class="btn btn-primary"
                                        title="Imprimir Ruta">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row mt-1">
                    <div  class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <div class="table-responsive">
                            @if ($reporte == 1)
                                <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
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
                                                <td class="text-center">{{ $item->total_vehiculos }}</td>
                                                <td class="text-right">{{ $item->total_votantes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Total</td>
                                            <td class="text-right">{{ $data->sum('total_votantes') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @else
                                <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
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
                                                <td>{{ $item->vehiculo }}</td>
                                                <td class="text-right">{{ $item->total_votantes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Total</td>
                                            <td class="text-right">{{ $data->sum('total_votantes') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('plugins/select2/custom-select2.js')}}"></script>
@endsection
