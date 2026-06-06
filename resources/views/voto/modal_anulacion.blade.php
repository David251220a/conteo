<div class="modal fade" wire:ignore.self id="carga_{{ $item->id }}" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="referente_titulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="referente_titulo">
                    Anular cargar?
                </h5>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Cancelar
                </button>

                <a href="{{ route('voto.anular_carga_voto', $item->id) }}" class="btn btn-danger btn-sm">
                    Anular
                </a>

            </div>
        </div>
    </div>
</div>
