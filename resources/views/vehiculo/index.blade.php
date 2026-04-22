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
                        <h3 class="mb-0">Vehiculos</h3>
                    </div>

                    {{-- @can('vehiculo.create') --}}
                        <div class="col-md-6 text-end">
                            <a href="{{route('vehiculo.create')}}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Agregar
                            </a>
                        </div>
                    {{-- @endcan --}}

                </div>

                @include('varios.mensaje')

                <form action="{{ route('vehiculo.index') }}" method="GET">
                    <div class="row align-items-center">

                        <!-- LOCAL -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="local_id">Local</label>
                                <select name="local_id" id="local_id" class="form-control">
                                    <option value="">-- Todos --</option>
                                    @foreach ($locales as $item)
                                        <option value="{{ $item->id }}" {{ request('local_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->descripcion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- BUSQUEDA -->
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="search">Búsqueda</label>
                                <input type="text"
                                    name="search"
                                    id="search"
                                    class="form-control"
                                    placeholder="Nombre, apellido o documento..."
                                    value="{{ $search }}">
                            </div>
                        </div>

                        <!-- BOTON -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-info w-10">
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
                                        <th class="">Documento</th>
                                        <th class="">Nombre</th>
                                        <th>Chapa</th>
                                        <th>Monto</th>
                                        <th>Pagado</th>
                                        <th>Referente Asociado</th>
                                        <th>Locales</th>
                                        <th>Estado</th>
                                        <th class="text-center">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="">
                                                {{number_format($item->documento, 0, ".", ".")}}
                                            </td>
                                            <td>
                                                {{$item->nombre}}
                                            </td>
                                            <td>{{$item->chapa}}</td>
                                            <td class="text-right">{{number_format($item->monto, 0, ".", ".")}}</td>
                                            <td>
                                                @if ($item->pagado == 1)
                                                    <button type="button" class="btn btn-sm btn-success">SI</button>
                                                @else
                                                    <form action="{{route('vehiculo.pagar', $item)}}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">NO</button>
                                                    </form>

                                                @endif
                                            </td>
                                            <td>
                                                {{$item->refe->referente}}
                                            </td>
                                            <td class="">

                                                @foreach ($item->vehiculo_local as $valor)
                                                    <li class="mx-2">{{$valor->local->descripcion}}</li>
                                                @endforeach

                                            </td>
                                            <td>{{$item->estado->descripcion}}</td>
                                            <td class="text-center">
                                                {{-- @can('vehiculo.edit') --}}
                                                   <a href="{{route('vehiculo.edit', $item)}}" class="ml-3">
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
                                    <tr>
                                        <th colspan="8">
                                            Cantidad Vehiculos
                                        </th>
                                        <th class="text-right">
                                            {{number_format($cantidadTotal, 0, ".", ".")}}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="8">
                                            Total Monto
                                        </th>
                                        <th class="text-right">
                                            {{number_format($montoTotal, 0, ".", ".")}}
                                        </th>
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
@endsection
