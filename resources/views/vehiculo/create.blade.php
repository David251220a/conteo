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
                        <h3 class="mb-0">Crear Vehiculo</h3>
                    </div>
                </div>
                @include('varios.mensaje')
                <form id="form_general" action="{{route('vehiculo.store')}}" method="post"
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
                                    <input name="documento" id="documento" type="text" class="form-control" value="{{old('documento')}}" onkeyup="punto_decimal(this)" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="nombre">Nombre y Apellido</label>
                                    <input name="nombre" id="nombre" type="text" class="form-control" value="{{old('nombre')}}" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="chapa">Chapa</label>
                                    <input name="chapa" id="chapa" type="text" class="form-control" value="{{old('chapa')}}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="referente_id">Referente</label>
                                    <select name="referente_id" id="referente_id" class="form-control basic">
                                        @foreach ($referentes as $item)
                                            <option {{ (old('referente_id') == $item->id ? 'selected' : '') }}  value="{{$item->id}}">{{$item->referente}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="local_id">local</label>
                                    <select name="local_id" id="local_id" class="form-control basic">
                                        @foreach ($locales as $item)
                                            <option {{ (old('local_id') == $item->id ? 'selected' : '') }}  value="{{$item->id}}">{{$item->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="monto">Monto</label>
                                    <input name="monto" id="monto" type="text" class="form-control" value="{{old('monto')}}" onkeyup="punto_decimal(this)" required>
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
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('plugins/select2/custom-select2.js')}}"></script>
@endsection
