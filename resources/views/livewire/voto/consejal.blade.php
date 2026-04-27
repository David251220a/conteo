 <div  class="col-lg-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <h3 class="mb-0">Votos Consejal Manual</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-row mb-2">
                        <div class="form-group col-md-3">
                            <label for="local_id">Local</label>
                            <select wire:model='local_id' class="form-control">
                                @foreach ($locales as $item)
                                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="mesa_id">Mesa</label>
                            <select wire:model.defer='mesa_id' class="form-control">
                                @foreach ($mesas as $item)
                                    <option value="{{$item->id}}">{{$item->mesa}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="normal">Forma Carga</label>
                            <select wire:model='normal' class="form-control">
                                <option value="1">LISTA/OPCION</option>
                                <option value="2">OPCION/LISTA</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row mb-2">
                        <div class="table-responsive">
                            @if ($normal == 1)
                                <table class="table table-bordered table-sm text-center">
                                    <thead>
                                        <tr>
                                            <th>Orden</th>

                                            @foreach($listasCandidatos as $listaId => $candidatosLista)
                                                <th>
                                                    {{ optional($candidatosLista->first()->lista)->descripcion }}
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($ordenesNormales as $orden)
                                            <tr>
                                                <td>{{ $orden }}</td>

                                                @foreach($listasCandidatos as $listaId => $candidatosLista)
                                                    @php
                                                        $candidato = $candidatosLista->firstWhere('orden', $orden);
                                                    @endphp

                                                    <td>
                                                        @if($candidato)
                                                            <input type="number"
                                                                min="0"
                                                                class="form-control form-control-sm text-center"
                                                                wire:model="votos.{{ $candidato->id }}">
                                                        @else
                                                            <input type="number"
                                                                class="form-control form-control-sm text-center"
                                                                value="0"
                                                                disabled>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach

                                        <tr class="font-weight-bold bg-light">
                                            <td>SUB TOTAL</td>

                                            @foreach($listasCandidatos as $listaId => $candidatosLista)
                                                <td>
                                                    {{ number_format($this->subtotalPorLista($listaId), 0, ',', '.') }}
                                                </td>
                                            @endforeach
                                        </tr>

                                        @foreach($candidatosEspeciales as $especial)
                                            <tr>
                                                <td>{{ $especial->orden }}</td>
                                                <td colspan="{{ count($listasCandidatos) - 1 }}" class="text-left">
                                                    {{ $especial->nombre ?? $especial->descripcion }}
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        min="0"
                                                        class="form-control form-control-sm text-center"
                                                        wire:model="votos.{{ $especial->id }}">
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr class="font-weight-bold bg-light">
                                            <td>Total</td>
                                            <td colspan="{{ count($listasCandidatos) }}">
                                                {{ number_format($this->totalVotos, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <table class="table table-bordered table-sm text-center">
                                    <thead>
                                        <tr>
                                            <th>Lista</th>

                                            @foreach($ordenesNormales as $orden)
                                                <th>Orden {{ $orden }}</th>
                                            @endforeach

                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($listasCandidatos as $listaId => $candidatosLista)
                                            <tr>
                                                <td>
                                                    {{ optional($candidatosLista->first()->lista)->descripcion }}
                                                </td>

                                                @foreach($ordenesNormales as $orden)
                                                    @php
                                                        $candidato = $candidatosLista->firstWhere('orden', $orden);
                                                    @endphp

                                                    <td>
                                                        @if($candidato)
                                                            <input type="number"
                                                                min="0"
                                                                class="form-control form-control-sm text-center"
                                                                wire:model="votos.{{ $candidato->id }}">
                                                        @else
                                                            <input type="number"
                                                                value="0"
                                                                class="form-control form-control-sm text-center"
                                                                disabled>
                                                        @endif
                                                    </td>
                                                @endforeach

                                                <td>
                                                    <strong>{{ number_format($this->subtotalPorLista($listaId), 0, ',', '.') }}</strong>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @foreach($candidatosEspeciales as $especial)
                                            <tr>
                                                <td>{{ $especial->orden }} - {{ $especial->nombre ?? $especial->descripcion }}</td>

                                                <td colspan="{{ count($ordenesNormales) }}">
                                                    <input type="number"
                                                        min="0"
                                                        class="form-control form-control-sm text-center"
                                                        wire:model="votos.{{ $especial->id }}">
                                                </td>

                                                <td>
                                                    {{ (int) ($votos[$especial->id] ?? 0) }}
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr class="font-weight-bold bg-light">
                                            <td>Total</td>
                                            <td colspan="{{ count($ordenesNormales) + 1 }}">
                                                {{ number_format($this->totalVotos, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif

                        </div>
                    </div>

                    <div class="form-row">
                        <button
                            wire:click="grabar"
                            wire:loading.attr="disabled"
                            wire:target="grabar"
                            class="btn btn-success"
                            @if(!$mesa_id) disabled @endif
                        >
                            <span wire:loading.remove wire:target="grabar">
                                Guardar
                            </span>

                            <span wire:loading wire:target="grabar">
                                Guardando...
                            </span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
