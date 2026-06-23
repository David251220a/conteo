$(document).ready(function () {
    $('.basic').select2({
        width: '100%'
    });

    function cargarMoviles(referenteId) {
        let $movil = $('#movil_id');

        $.ajax({
            url: '/consulta/referentes-ver-movil/' + referenteId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $movil.empty();

                $.each(data, function (index, item) {
                    $movil.append(
                        new Option(item.nombre, item.id, false, false)
                    );
                });

                $movil.trigger('change');
            },
            error: function () {
                $movil.empty();
                $movil.append(
                    new Option('Sin especificar', 1, true, true)
                );
                $movil.val('1').trigger('change');
            }
        });
    }

    $(document).on('click', '.btn-cargar-movil', function () {

        let referenteId = $(this).data('referente-id');
        let vehiculoId  = $(this).data('vehiculo-id');
        let itemId      = $(this).data('item-id');

        cargarMovilesModal(referenteId, vehiculoId, itemId);

    });

    function cargarMovilesModal(referenteId, vehiculoId, itemId) {

        let $select = $('#aux_movil_id_' + itemId);

        $.ajax({
            url: '/consulta/referentes-ver-movil/' + referenteId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                $select.empty();

                $.each(data, function (index, item) {

                    let selected = parseInt(item.id) === parseInt(vehiculoId);

                    $select.append(
                        new Option(item.nombre, item.id, selected, selected)
                    );
                });

                $select.trigger('change');
            },
            error: function () {

                $select.empty();

                $select.append(
                    new Option('Sin especificar', 0, true, true)
                );

                $select.trigger('change');
            }
        });

    }

});
