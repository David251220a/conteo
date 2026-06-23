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
                        <h3 class="mb-0">Padron</h3>
                    </div>
                </div>

                <form action="{{ route('padron.todos') }}" method="GET">
                    <div class="row align-items-end">
                        <!-- TIPO CANDIDATO -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="search">Busqueda</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control">
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
                                        <th class="">Documento</th>
                                        <th class="">Votante</th>
                                        <th class="">Local</th>
                                        <th class="">Mesa y Orden</th>
                                        <th>Referente</th>
                                        <th>Vehiculo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-right">{{number_format($item->documento, 0, ',', '.')}}</td>
                                            <td>{{$item->nombre .' ' . $item->apellido}}</td>
                                            <td>{{$item->local->descripcion}}</td>
                                            <td>{{$item->mesa .' || ' . $item->orden}}</td>
                                            <td>
                                                <button type="button"
                                                    class="btn {{$item->referente_id > 1 ? 'btn-success' : 'btn-danger'}} btn-sm btn-cargar-movil"
                                                    data-toggle="modal"
                                                    data-target="#carga_refe_{{ $item->id }}"
                                                    data-item-id="{{ $item->id }}">
                                                    {{ $item->refe ? $item->refe->referente : 'SIN ESPECIFICAR' }}
                                                </button>

                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn {{$item->vehiculo_id > 0 ? 'btn-success' : 'btn-danger'}} btn-sm btn-cargar-movil"
                                                    data-toggle="modal"
                                                    data-target="#carga_{{ $item->id }}"
                                                    data-item-id="{{ $item->id }}">
                                                    {{ $item->vehiculo_id > 0 ? $item->Vehiculo->nombre : 'SIN ESPECIFICAR' }}
                                                </button>
                                            </td>
                                        </tr>
                                        @include('padron.modal_asignar_movil')
                                        @include('padron.modal_asignar_refe')
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6"></td>
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
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('plugins/select2/custom-select2.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.select2-modal').each(function () {
                let modal = $(this).closest('.modal');

                $(this).select2({
                    width: '100%',
                    dropdownParent: modal
                });
            });
        });
    </script>
@endsection
