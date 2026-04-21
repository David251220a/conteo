<div class="modal fade" wire:ignore.self id="vehiculo_modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="vehiculo_titulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="vehiculo_titulo">
                    Asignar Vehiculo
                </h5>
            </div>

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="documento">Vehiculo</label>
                        <select name="vehiculo_id" id="vehiculo_id" class="form-control">
                            @foreach ($vehiculos as $item)
                                <option value="{{$item->id}}">{{$item->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Cancelar
                </button>

                <button type="button" onclick="guardarVehiculoSeleccionado({{ $data->id ?? 0 }})" class="btn btn-success">
                    Cambiar
                </button>

            </div>
        </div>
    </div>
</div>
