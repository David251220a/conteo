<div class="modal fade" id="carga_refe_{{ $item->id }}" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="referente_titulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{route('padron.asignar_refe')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="referente_asignar">
                        Asignar Referente
                    </h5>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-row mb-2">
                                <div class="form-group col-md-12">
                                    <label for="aux_refe_id">Referente</label>
                                    <select name="aux_refe_id" class="form-control select2-modal">
                                        @foreach ($punteros as $pun)
                                            <option value="{{ $pun->id }}" {{ $item->referente_id == $pun->id ? 'selected' : '' }}>
                                                {{ $pun->referente }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{ $item->id }}" name="padron_id_aux_refe">
                        <input type="hidden" value="{{ request('search') }}" name="search_aux_refe">
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
