 <div  class="col-lg-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <h3 class="mb-0">Sondeo de Votos
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-row mb-2">
                        <div class="form-group col-md-3">
                            <label>Tipo Candidato</label>
                            <select wire:model="tipo_candidato_id" class="form-control">
                                <option value="4">INTENDENTE</option>
                                <option value="5">CONCEJAL</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Reporte</label>
                            <select wire:model="tipo" class="form-control">
                                <option value="1">GENERAL</option>
                                <option value="2">LOCAL</option>
                                <option value="3">LISTA</option>
                            </select>
                        </div>
                        @if($tipo >= 2)
                            <div class="form-group col-md-3">
                                <label>Local</label>
                                <select wire:model="local_id" class="form-control">
                                    <option value="0">TODOS</option>
                                    @foreach ($locales as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->descripcion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        @if($tipo == 3)
                            <div class="form-group col-md-3">
                                <label>Lista</label>
                                <select wire:model="lista_id" class="form-control">
                                    <option value="0">TODOS</option>
                                    @foreach ($listas as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->descripcion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="row">

                <div  class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <div wire:poll.30s class="table-responsive">
                        <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                            <thead>
                                <tr>
                                    <th colspan="10" class="text-center">
                                        {{ $tipo_candidato_id == 4 ? 'INTENDENTE' : 'CONCEJAL' }}
                                    </th>
                                </tr>
                                <tr>
                                    <th class="">Lista</th>
                                    @if ($tipo <> 3)
                                        <th class="">Candidato</th>
                                    @endif

                                    @if ($tipo == 2)
                                        <th>Local</th>
                                    @endif
                                    <th class="text-center">Votos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="">{{$item->lista}}</td>
                                        @if ($tipo <> 3)
                                            <td>{{ $item->nombre }}</td>
                                        @endif
                                        @if ($tipo == 2)
                                            <td>{{ $item->local }}</td>
                                        @endif
                                        <td class="text-right">{{ number_format($item->total_votos, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <th>
                                    <td colspan="10" class="text-right">Total: {{ number_format($data->sum('total_votos'), 0, ',', '.') }}</td>
                                </th>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
