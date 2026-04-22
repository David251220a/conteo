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
                        <h3 class="mb-0">Crear Lista</h3>
                    </div>
                </div>
                @include('varios.mensaje')
                <form id="form_general" action="{{route('lista.store')}}" method="post"
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
                                    <label for="lista">Lista</label>
                                    <input name="lista" id="lista" type="text" class="form-control" value="{{old('lista', "LISTA ")}}" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="opcion">Opcion</label>
                                    <input name="opcion" id="opcion" type="text" class="form-control" value="{{old('opcion')}}" onkeyup="punto_decimal(this)" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="orden">Orden</label>
                                    <input name="orden" id="orden" type="text" class="form-control" value="{{old('orden')}}" onkeyup="punto_decimal(this)" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="movimiento_id">Movimiento</label>
                                    <select name="movimiento_id" id="movimiento_id" class="form-control">
                                        @foreach ($movimientos as $item)
                                            <option {{ ( old('movimiento_id') == $item->id ? 'selected' : '') }} value="{{$item->id}}">{{$item->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="tipo_candidato_id">Tipo Candidato</label>
                                    <select name="tipo_candidato_id" id="tipo_candidato_id" class="form-control">
                                        @foreach ($tipoCandidato as $item)
                                            <option {{ ( old('tipo_candidato_id') == $item->id ? 'selected' : '') }} value="{{$item->id}}">{{$item->descripcion}}</option>
                                        @endforeach
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
