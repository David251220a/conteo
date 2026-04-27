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


                    </div>
                    <div class="form-row mb-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Orden</th>
                                        @foreach ($listasCandidatos as $listaId => $candidatosLista)
                                            <th>{{ $candidatosLista->first()->lista->descripcion ?? '' }}</th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody>
                                    {{-- MATRIZ SOLO CANDIDATOS NORMALES --}}
                                    @foreach ($ordenesNormales as $orden)
                                        <tr>
                                            <td><strong>{{ $orden }}</strong></td>

                                            @foreach ($listasCandidatos as $listaId => $candidatosLista)
                                                @php
                                                    $candidato = $candidatosLista->firstWhere('orden', $orden);
                                                @endphp

                                                <td>
                                                    @if($candidato)
                                                        <input type="number"
                                                            min="0"
                                                            class="form-control form-control-sm text-center"
                                                            wire:model.lazy="votos.{{ $candidato->id }}">
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach

                                    {{-- SUBTOTAL POR LISTA --}}
                                    <tr class="table-info">
                                        <td><strong>SUB TOTAL</strong></td>
                                        @foreach ($listasCandidatos as $listaId => $candidatosLista)
                                            <td><strong>{{ $this->subtotalPorLista($listaId) }}</strong></td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- NULOS / BLANCOS / A COMPUTAR --}}
                        <table class="table table-bordered table-sm mt-3" style="max-width: 400px;">
                            <tbody>
                                @foreach ($candidatosEspeciales as $item)
                                    <tr>
                                        <td><strong>{{ $item->candidato }}</strong></td>
                                        <td width="140">
                                            <input type="number"
                                                min="0"
                                                class="form-control form-control-sm text-center"
                                                wire:model.lazy="votos.{{ $item->id }}">
                                        </td>
                                    </tr>
                                @endforeach

                                <tr class="table-success">
                                    <td><strong>TOTAL</strong></td>
                                    <td><strong>{{ $this->totalVotos }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
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
