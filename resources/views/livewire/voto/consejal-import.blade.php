 <div  class="col-lg-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <h3 class="mb-0">Votos Consejal Importar - <button type="button" class="btn btn-danger btn-sm" wire:click="descargarPlantilla">Formato</button></h3>
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
                            <select wire:model='mesa_id' class="form-control">
                                @foreach ($mesas as $item)
                                    <option value="{{$item->id}}">{{$item->mesa}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="normal">Forma Carga</label>
                            <select wire:model='normal' class="form-control">
                                <option value="1">OPCION/LISTA</option>
                                <option value="2">LISTA/OPCION</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-row mb-2">
                        <div class="form-group col-md-4">
                            <label>Archivo Excel</label>
                            <input type="file" wire:model="archivo" wire:key="archivo-{{ $normal }}-{{ $local_id }}-{{ $mesa_id }}" class="form-control" accept=".xlsx,.xls,.csv">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Nulos</label>
                            <input type="number" wire:model.defer="nulos" class="form-control" min="0">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Blancos</label>
                            <input type="number" wire:model.defer="blancos" class="form-control" min="0">
                        </div>

                        <div class="form-group col-md-2">
                            <label>A computar</label>
                            <input type="number" wire:model.defer="a_computar" class="form-control" min="0">
                        </div>

                        <div class="form-group col-md-2">
                            <label>&nbsp;</label>
                            <button type="button" wire:click="verificarExcel" class="btn btn-info btn-block">
                                Verificar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @if ($verificado)
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="alert alert-success">
                            Archivo verificado correctamente.
                            Total candidatos: <b>{{ number_format($total_excel, 0, ',', '.') }}</b> |
                            Extras: <b>{{ number_format($total_extras, 0, ',', '.') }}</b> |
                            Total general: <b>{{ number_format($total_general, 0, ',', '.') }}</b>
                        </div>

                        <button type="button" wire:click="guardarVotos" wire:loading.attr="disabled" class="btn btn-success">
                            <span wire:loading.remove>
                                Guardar votos
                            </span>

                            <span wire:loading>
                                Guardando...
                            </span>
                        </button>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
