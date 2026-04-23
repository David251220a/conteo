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
                        <h3 class="mb-0">Candidato</h3>
                    </div>

                    {{-- @can('lista.create') --}}
                        <div class="col-md-6 text-end">
                            <a href="{{route('candidato.create')}}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Agregar
                            </a>
                        </div>
                    {{-- @endcan --}}

                </div>

                @include('varios.mensaje')

                <form action="{{ route('candidato.index') }}" method="GET">
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
                                <label for="movimiento_id">Movimiento</label>
                                <select name="movimiento_id" id="movimiento_id" class="form-control">
                                    <option value="0">-- Todos --</option>
                                    @foreach ($movimientos as $item)
                                        <option {{ request('movimiento_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
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
                            <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th class="">Lista</th>
                                        <th class="">Movimiento</th>
                                        <th>Orden</th>
                                        <th>Imagen</th>
                                        <th class="text-center">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>
                                                {{$item->nombre}}
                                            </td>
                                            <td>{{$item->lista->descripcion}}</td>
                                            <td>{{$item->Movimiento->descripcion}}</td>
                                            <td>{{$item->orden}}</td>
                                            <td>
                                                @if ($item->imagen)
                                                    <a href="{{ Storage::url($item->imagen)}}" class="btn btn-sm btn-success" target="__blank">SI</a>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-danger">NO</button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{-- @can('candidato.edit') --}}
                                                   <a href="{{route('candidato.edit', $item)}}" class="ml-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                        </svg>
                                                    </a>
                                                {{-- @endcan --}}
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
@endsection
