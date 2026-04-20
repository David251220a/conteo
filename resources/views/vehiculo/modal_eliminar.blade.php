<div class="modal fade" id="exampleModalCenter_{{ $item->id }}" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="modalTitle_{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle_{{ $item->id }}">
                    Eliminar Local Asociado
                </h5>
            </div>

            <div class="modal-body">
                ¿Está seguro que desea eliminar este local?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Cancelar
                </button>
                <form action="{{route('vehiculo.eliminar_local', $item)}}" method="POST">
                    @csrf
                    <button type="submit"  class="btn btn-danger">
                        Eliminar
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>
