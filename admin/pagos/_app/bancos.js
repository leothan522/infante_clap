//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('table_bancos');

inputmask('#bancos_form_codigo', 'numerico', 4, 4, '');

$('#bancos_form').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let nombre = $('#bancos_form_nombre');
    let codigo = $('#bancos_form_codigo');

    if (nombre.val().length <= 0) {
        procesar = false;
        nombre.addClass('is-invalid');
        $('#error_bancos_nombre').text('El nombre es Obligatorio.');
    } else {
        nombre
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!codigo.inputmask("isComplete")) {
        procesar = false;
        codigo.addClass('is-invalid');
        $('#error_bancos_codigo').text('El código es obligatorio y debe tener 4 digitos.');
    } else {
        codigo
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (procesar) {
        ajaxRequest({url: '_request/BancosRequest.php', data: $(this).serialize(), html: 'si'}, function (data) {

            if (data.is_json) {
                if (data.error === 'error_nombre') {
                    $('#bancos_form_nombre').addClass('is-invalid');
                    $('#error_bancos_nombre').text('El nombre ya esta registrado.');
                }

                if (data.error === 'error_codigo') {
                    codigo.addClass('is-invalid');
                    $('#error_bancos_codigo').text('El codigo ya esta registrado.');
                }

                if (data.error === 'error_nombre_codigo'){
                    nombre.addClass('is-invalid');
                    codigo.addClass('is-invalid');
                    $('#error_bancos_nombre').text('El nombre ya esta registrado.');
                    $('#error_bancos_codigo').text('El codigo ya esta registrado.');
                }

            } else {
                $('#dataContainerBancos').html(data.html);
                resetForm();
            }
        });
    }

});

function resetForm() {
    $('#bancos_form_nombre')
        .val('')
        .removeClass('is-valid');
    $('#bancos_form_codigo')
        .val('')
        .removeClass('is-valid');
    $('#bancos_opcion').val('store');
}