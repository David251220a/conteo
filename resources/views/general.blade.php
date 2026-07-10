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
                        <h3 class="mb-0">General</h3>
                    </div>
                </div>
                @include('varios.mensaje')
                <form id="form_general" action="#" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-row mb-2">
                                <div class="form-group col-md-3">
                                    <label for="anio">Año</label>
                                    <input name="anio" id="anio" type="text" class="form-control" value="{{old('anio', $data->anio)}}" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="tipo_votacion">Tipo Votacion</label>
                                    <select name="tipo_votacion" id="tipo_votacion" class="form-control">
                                        <option {{ ($data->tipo_votacion == 1 ? 'selected' : '') }} value="1">INTERNAS</option>
                                        <option {{ ($data->tipo_votacion == 2 ? 'selected' : '') }} value="2">GENERALES</option>
                                        <option {{ ($data->tipo_votacion == 3 ? 'selected' : '') }} value="3">PRESIDENCIA INTERNAS</option>
                                        <option {{ ($data->tipo_votacion == 4 ? 'selected' : '') }} value="4">PRESIDENCIA GENERALES</option>
                                    </select>
                                </div>

                            </div>

                            <div class="form-row">
                                <button id="btnEnviar" type="submit" class="btn btn-success">
                                    Actualizar
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
