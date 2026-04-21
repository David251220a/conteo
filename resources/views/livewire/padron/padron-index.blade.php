 <div  class="col-lg-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <h3 class="mb-0">Padron</h3>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="search">Documento</label>

                    <div class="input-group">
                        <input type="text" class="form-control" wire:model.defer='documento' onkeyup="punto_decimal(this)">

                        <div class="input-group-append">
                            <button type="buttin" wire:click='buscar' class="btn btn-info">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div  class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                            <thead>
                                <tr class="text-center">
                                    <th>
                                        Padron
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if ($data)
                                    <tr>
                                        <td>Nombre y Apellido</td>
                                    </tr>
                                    <tr>
                                        <td><b>{{$data->nombre}} {{$data->apellido}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Local</td>
                                    </tr>
                                    <tr>
                                        <td><b>{{$data->local->descripcion}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Mesa</td>
                                    </tr>
                                    <tr>
                                        <td>Mesa: <b>{{$data->mesa}}</b> | Orden:<b>{{$data->orden}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Consultado fecha</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>{{ \Carbon\Carbon::parse($data->padronConsulta()->latest()->first()->created_at)->format('d/m/Y H:i') }}
                                                | Cantidad: {{$data->padronConsulta()->count()}}
                                            </b>
                                            <button type="button" wire:click="toggleVerMas" class="btn btn-sm btn-primary ml-2">
                                                {{ $verMas ? '-' : '+' }}
                                            </button>
                                        </td>
                                    </tr>
                                    @if ($verMas)
                                        @if ($general->voto == 1)
                                            <tr>
                                                <td>Voto?</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" wire:click="padron_voto" {{ ($data->voto == 1 ? 'checked' : '') }}>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>
                                                Referente <button type="button" class="btn btn-sm btn-info mr-3" data-toggle="modal" data-target="#referente_modal"><i class="fas fa-user-edit"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if ($data->referente_id <> 0)
                                                    <b>{{$data->refe->referente}}</b>
                                                @else
                                                    <b>SIN ASIGNAR</b>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Vehiculo <button type="button" class="btn btn-sm btn-info mr-3" data-toggle="modal" data-target="#vehiculo_modal"><i class="fas fa-car-side"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if ($data->vehiculo_id <> 0)
                                                    <b>{{$data->vehiculo->nombre}}</b>
                                                @else
                                                    <b>SIN ASIGNAR</b>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Mapa @if ($data->latitude && $data->longitude)
                                                        <a href="https://www.google.com/maps?q={{ $data->latitude }},{{ $data->longitude }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-success ml-2">
                                                            <i class="fas fa-map-marker-alt"></i> Ir
                                                        </a>
                                                        <a href="https://wa.me/?text={{ urlencode('Ubicación de ' . $data->nombre . ' ' . $data->apellido . ': https://www.google.com/maps?q=' . $data->latitude . ',' . $data->longitude) }}"
                                                            target="_blank"
                                                            class="btn btn-sm btn-success ml-2">
                                                            <i class="fas fa-phone"></i>
                                                        </a>
                                                    @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="hidden" id="latitude" value="{{ $data->latitude ?? '' }}">
                                                <input type="hidden" id="longitude" value="{{ $data->longitude ?? '' }}">
                                                <div id="map" data-lat="{{ $data->latitude ?? '' }}" data-lng="{{ $data->longitude ?? '' }}"></div>
                                                <button type="button" class="btn btn-sm btn-success mt-2" onclick="guardarPosicion({{ $data->id ?? 0 }})">Guardar Posicion</button>
                                            </td>
                                        </tr>
                                    @endif

                                @else
                                    <tr>
                                        <td class="text-center">No existe persona con este numero de documento.</td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('padron.modal_referente')
    @include('padron.modal_vehiculo')
</div>


