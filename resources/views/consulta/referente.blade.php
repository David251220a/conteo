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
                        <h3 class="mb-0">Consulta Referente</h3>
                    </div>
                </div>

                <form action="{{route('consulta.referente')}}" method="GET">
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
                                    <label for="referente_id">Referente</label>
                                    <select name="referente_id" id="referente_id" class="form-control basic">
                                        @foreach ($referentes as $item)
                                            <option {{ request('referente_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                                                {{ $item->referente }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3 d-flex align-items-center">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-search"></i> Buscar
                                    </button>
                                </div>
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
                                        <th class="">Documento</th>
                                        <th class="">Nombre y Apellido</th>
                                        <th>Local</th>
                                        <th>Mesa Orden</th>
                                        @if (request('referente_id') <= 1)
                                            <th>Referente</th>
                                        @endif
                                        <th width="13%" class="text-center">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{$item->documento}}</td>
                                            <td>{{$item->nombre}} {{$item->apellido}}</td>
                                            <td>{{$item->local->descripcion}}</td>
                                            <td>Mesa: {{$item->mesa}} | Orden: {{$item->orden}}</td>
                                            @if (request('referente_id') <= 1)
                                                <td>{{$item->refe->referente}}</td>
                                            @endif
                                            <td>
                                                <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}"
                                                    target="_blank"
                                                    class="btn btn-sm btn-success ml-2">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </a>
                                                <a href="https://wa.me/?text={{ urlencode('Ubicación de ' . $item->nombre . ' ' . $item->apellido . ': https://www.google.com/maps?q=' . $item->latitude . ',' . $item->longitude) }}"
                                                    target="_blank"
                                                    class="btn btn-sm btn-success ml-2">
                                                    <i class="fas fa-phone"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <th>
                                        <td colspan="7"></td>
                                    </th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- {{ $data->appends(request()->query())->links() }} --}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('plugins/select2/custom-select2.js')}}"></script>
    <script src="{{asset('js/referente.js')}}"></script>
@endsection
