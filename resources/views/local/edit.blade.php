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
                        <h3 class="mb-0">Editar Local</h3>
                    </div>
                </div>
                @include('varios.mensaje')
                <form id="form_general" action="{{route('local.update', $data)}}" method="post"
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
                                <div class="form-group col-md-6">
                                    <label for="descripcion">Local</label>
                                    <input name="descripcion" id="descripcion" type="text" class="form-control" value="{{old('descripcion', $data->descripcion)}}" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="orden">Orden</label>
                                    <input name="orden" id="orden" type="text" class="form-control" value="{{old('orden', $data->orden)}}" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="estado_id">Estado</label>
                                    <select name="estado_id" id="estado_id" class="form-control">
                                        <option {{ ( old('estado_id', $data->estado_id) == 1 ? 'selected' : '' ) }} value="1">ACTIVO</option>
                                        <option {{ ( old('estado_id', $data->estado_id) == 2 ? 'selected' : '' ) }} value="2">INACTIVO</option>
                                    </select>
                                </div>

                            </div>

                            <div class="form-row">
                                <button id="btnEnviar" type="submit" class="btn btn-success">
                                    Grabar
                                </button>
                            </div>

                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection


@section('js')
@endsection
