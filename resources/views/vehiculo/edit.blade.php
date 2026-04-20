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
                        <h3 class="mb-0">Editar Vehiculo</h3>
                    </div>
                </div>
                @include('varios.mensaje')
                <form id="form_general" action="{{route('vehiculo.update', $data)}}" method="post"
                    onsubmit="
                    if (this.dataset.enviando === '1') return false;
                    this.dataset.enviando = '1';
                    document.getElementById('btnEnviar').disabled = true;
                    document.getElementById('btnEnviar').innerText = 'Enviando...';"
                >

                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-row mb-2">
                                <div class="form-group col-md-3">
                                    <label for="documento">Documento</label>
                                    <input name="documento" id="documento" type="text" class="form-control" value="{{old('documento', $data->documento)}}" onkeyup="punto_decimal(this)" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="nombre">Nombre y Apellido</label>
                                    <input name="nombre" id="nombre" type="text" class="form-control" value="{{old('nombre', $data->nombre)}}" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="chapa">Chapa</label>
                                    <input name="chapa" id="chapa" type="text" class="form-control" value="{{old('chapa', $data->chapa)}}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="referente_id">Referente</label>
                                    <select name="referente_id" id="referente_id" class="form-control basic">
                                        @foreach ($referentes as $item)
                                            <option {{ (old('referente_id', $data->referente_id) == $item->id ? 'selected' : '') }}  value="{{$item->id}}">{{$item->referente}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="local_id">local</label>
                                    <select name="local_id" id="local_id" class="form-control basic">
                                        @foreach ($locales as $item)
                                            <option {{ (old('local_id', $data->local_id) == $item->id ? 'selected' : '') }}  value="{{$item->id}}">{{$item->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="estado_id">Estado</label>
                                    <select name="estado_id" id="estado_id" class="form-control basic">
                                        <option {{ (old('estado_id', $data->estado_id) == 1 ? 'selected' : '') }}  value="1">ACTIVO</option>
                                        <option {{ (old('estado_id', $data->estado_id) == 2 ? 'selected' : '') }}  value="2">INACTIVO</option>
                                    </select>
                                </div>

                            </div>

                            <div class="form-row">
                                <button id="btnEnviar" type="submit" class="btn btn-success">
                                    Editar
                                </button>
                            </div>

                        </div>
                    </div>

                </form>

                <div class="row mt-4">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h4>Locales Asociados - <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#agregar_local">Agregar</button></h4>
                        @include('vehiculo.modal_agregar')
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                                <thead>
                                    <tr>
                                        <th class="">Local</th>
                                        <th class="text-center">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->vehiculo_local as $item)
                                        <tr>
                                            <td>{{$item->local->descripcion}}</td>
                                            <td class="text-center">
                                                    <button type="button" class="btn btn-danger mr-3" data-toggle="modal" data-target="#exampleModalCenter_{{ $item->id }}">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line>
                                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                                        </svg>
                                                    </button>
                                                    @include('vehiculo.modal_eliminar')
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

            </div>
        </div>
    </div>

@endsection


@section('js')
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('plugins/select2/custom-select2.js')}}"></script>
@endsection
