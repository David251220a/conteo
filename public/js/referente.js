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

    $('#local_id').on('change', function () {
        let localId = $(this).val();
        let $referente = $('#referente_id');

        $.ajax({
            url: '/consulta/referentes-por-local/' + localId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $referente.empty();

                $.each(data, function (index, item) {
                    $referente.append(
                        new Option(item.referente, item.id, false, false)
                    );
                });

                $referente.val('1').trigger('change');

                cargarMoviles($referente.val());
            },
            error: function () {
                $referente.empty();
                $referente.append(
                    new Option('Sin especificar', 1, true, true)
                );

                $referente.val('1').trigger('change');

                cargarMoviles(1);
            }
        });
    });

    $('#referente_id').on('change', function () {
        let referenteId = $(this).val();

        cargarMoviles(referenteId);
    });

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


// $(document).ready(function () {
//     $('.basic').select2({
//         width: '100%'
//     });

//     $('#local_id').on('change', function () {
//         let localId = $(this).val();
//         let $referente = $('#referente_id');

//         $.ajax({
//             url: '/consulta/referentes-por-local/' + localId,
//             type: 'GET',
//             dataType: 'json',
//             success: function (data) {
//                 $referente.empty();

//                 $.each(data, function (index, item) {
//                     $referente.append(
//                         new Option(item.referente, item.id, false, false)
//                     );
//                 });

//                 $referente.val('1').trigger('change');
//             },
//             error: function () {
//                 $referente.empty();
//                 $referente.append(
//                     new Option('Sin especificar', 1, true, true)
//                 );
//                 $referente.trigger('change');
//             }
//         });
//     });
// });
