$(document).ready(function () {
    $('.basic').select2({
        width: '100%'
    });

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
            },
            error: function () {
                $referente.empty();
                $referente.append(
                    new Option('Sin especificar', 1, true, true)
                );
                $referente.trigger('change');
            }
        });
    });
});
