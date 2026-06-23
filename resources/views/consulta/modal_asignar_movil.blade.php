<div class="modal fade" id="carga_{{ $item->id }}" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="referente_titulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('consulta.referentes.asginar_movil')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="movil_asignar">
                        Asignar Movil
                    </h5>
                </div>

                <div class="class modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-row mb-2">
                                <div class="form-group col-md-12">
                                    <label for="aux_movil_id">Movil</label>
                                    <select
                                        id="aux_movil_id_{{ $item->id }}"
                                        name="aux_movil_id"
                                        class="form-control">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{ request('referente_id') }}" name="referente_id_aux">
                        <input type="hidden" value="{{ request('local_id') }}" name="local_id_aux">
                        <input type="hidden" value="{{ request('movil_id') }}" name="movil_id_aux">
                        <input type="hidden" value="{{ $item->id }}" name="padron_id_aux">
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
