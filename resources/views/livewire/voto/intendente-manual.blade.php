 <div  class="col-lg-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <h3 class="mb-0">Votos Intendente Manual</h3>
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
                            <table class="table table-bordered table-striped">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Lista</th>
                                        <th>Candidato</th>
                                        <th width="15%">Votos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($candidatos as $item)
                                        <tr>
                                            <td>
                                                {{ $item->lista->descripcion ?? '' }} - {{$item->movimiento->descripcion}}
                                            </td>
                                            <td>{{ $item->nombre }}</td>
                                            <td>
                                                <input
                                                    type="number"
                                                    min="0"
                                                    class="form-control text-right"
                                                    wire:model.lazy="votos.{{ $item->id }}"
                                                >
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr class="table-success font-weight-bold">
                                        <td class="" colspan="2" style="font-size: 20px; font-weight: bold;"><b>Total votos</b></td>
                                        <td class="font-weight-bold text-right fs-2" style="font-size: 20px; font-weight: bold;"><b>{{ $totalVotos }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
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
