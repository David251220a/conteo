<div class="modal fade" id="agregar_local" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="agregar_local_titulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{route('vehiculo.agregar_local', $data)}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="agregar_local_titulo">
                        Agregar Local
                    </h5>
                </div>

                <div class="modal-body">
                    <div class="form-row mb-2">
                        <div class="form-group col-md-12">
                            <label for="documento">Local</label>
                            <select name="agregar_local_id" id="agregar_local_id" class="form-control">
                                @foreach ($locales as $item)
                                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit"  class="btn btn-success">
                        Agregar
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
