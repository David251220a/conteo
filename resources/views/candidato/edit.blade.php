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
                        <h3 class="mb-0">Editar Candidato</h3>
                    </div>
                </div>
                @include('varios.mensaje')
                <form id="form_general" action="{{route('candidato.update', $data)}}" method="post" enctype="multipart/form-data"
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
                                    <label for="lista_id">Lista</label>
                                    <select name="lista_id" id="lista_id" class="form-control basic" required>
                                        @foreach ($listas as $item)
                                            <option {{ (old('lista_id', $data->lista_id) == $item->id ? 'selected' : '') }} value="{{$item->id}}">
                                                {{$item->descripcion}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="tipo_candidato_id">Tipo Candidato</label>
                                    <select name="tipo_candidato_id" id="tipo_candidato_id" class="form-control basic" required>
                                        @foreach ($tipoCandidato as $item)
                                            <option {{ (old('tipo_candidato_id', $data->tipo_cantidato_id) == $item->id ? 'selected' : '') }} value="{{$item->id}}">
                                                {{$item->descripcion}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="nombre">Nombre</label>
                                    <input name="nombre" id="nombre" type="text" class="form-control" value="{{old('nombre', $data->nombre)}}" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="orden">Orden</label>
                                    <input name="orden" id="orden" type="text" class="form-control" value="{{old('orden', $data->orden)}}" onkeyup="punto_decimal(this)" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="imagen">Imagen</label>
                                    <input name="imagen" id="imagen" type="file" class="form-control" value="{{old('imagen')}}" accept=".jpg,.jpeg,image/jpeg">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="estado_id">Estado</label>
                                    <select name="estado_id" id="estado_id" class="form-control basic" required>
                                        <option {{ (old('estado_id', $data->estado_id) == 1 ? 'selected' : '') }} value="1">ACTIVO</option>
                                        <option {{ (old('estado_id', $data->estado_id) == 2 ? 'selected' : '') }} value="2">INACTIVO</option>
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

            </div>
        </div>
    </div>

@endsection


@section('js')
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('plugins/select2/custom-select2.js')}}"></script>
@endsection
