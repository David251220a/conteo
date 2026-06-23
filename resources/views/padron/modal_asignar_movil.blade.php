<div class="modal fade" id="carga_{{ $item->id }}" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="movil_titulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{route('padron.asignar')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="movil_asignar">
                        Asignar Movil
                    </h5>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-row mb-2">
                                <div class="form-group col-md-12">
                                    <label for="aux_movil_id">Movil</label>
                                    <select name="aux_movil_id"
                                            class="form-control select2-modal">
                                        <option value="0" {{ $item->vehiculo_id == 0 ? 'selected' : '' }}>
                                            SIN ESPECIFICAR
                                        </option>

                                        @foreach ($moviles as $mov)
                                            <option value="{{ $mov->id }}" {{ $item->vehiculo_id == $mov->id ? 'selected' : '' }}>
                                                {{ $mov->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{ $item->id }}" name="padron_id_aux">
                        <input type="hidden" value="{{ request('search') }}" name="search_aux">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-success btn-sm">
                        Asignar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
