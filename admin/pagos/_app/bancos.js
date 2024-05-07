//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('table_bancos');

inputmask('#bancos_form_codigo', 'numerico', 4, 4, '');
inputmask('#bancos_form_nombre', 'alfanumerico', 5, 100, ' %.');
inputmask('#bancos_form_mini', 'alfanumerico', 5, 100, ' %.');
//$("#bancos_form_nombre").inputmask({ mask: "99999", placeholder: "" });

$('#bancos_form').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let nombre = $('#bancos_form_nombre');
    let mini = $('#bancos_form_mini');
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

    if (mini.val().length <= 0){
        procesar = false;
        mini.addClass('is-invalid');
        $('#error_bancos_mini').text('La abreviación es ocligatiria.')
    }else {
        mini
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
        let opcion = $('#bancos_opcion').val();
        if (opcion === 'store'){
            //GUARDO
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

                    if (data.error === 'error_nombre_mini_codigo'){
                        nombre.addClass('is-invalid');
                        codigo.addClass('is-invalid');
                        mini.addClass('is-invalid');
                        $('#error_bancos_nombre').text('El nombre ya esta registrado.');
                        $('#error_bancos_codigo').text('El codigo ya esta registrado.');
                        $('#error_bancos_mini').text('La abreviación ya esta registrada.')
                    }

                    if (data.error === 'error_mini'){
                        mini.addClass('is-invalid');
                        $('#error_bancos_mini').text('La abreviación ya esta registrada.')
                    }

                } else {
                    $('#dataContainerBancos').html(data.html);
                    datatable('table_bancos');
                    resetForm();
                }
            });
        }else {
            //EDITO
            ajaxRequest({ url: '_request/BancosRequest.php', data: $('#bancos_form'). serialize() }, function (data) {
                if (data.result) {

                    let table = $('#table_bancos').DataTable();
                    let tr = $('#tr_item_' + data.id);
                    table
                        .cell(tr.find('.nombre_banco')).data(data.nombre_banco)
                        .cell(tr.find('.codigo_banco')).data(data.codigo_banco)
                        .draw();

                }
                resetForm();
            });
        }
    }

});

function editBanco(id) {
    ajaxRequest({ url: '_request/BancosRequest.php', data: { opcion: 'edit', id: id } }, function (data) {
        if (data.result){
            $('#bancos_form_nombre').val(data.nombre);
            $('#bancos_form_mini').val(data.mini);
            $('#bancos_form_codigo').val(data.codigo);
            $('#bancos_id').val(data.id);
            $('#bancos_opcion').val('update');
        }
    });
}

function resetForm() {
    $('#bancos_form_nombre')
        .val('')
        .removeClass('is-valid');
    $('#bancos_form_codigo')
        .val('')
        .removeClass('is-valid');
    $('#bancos_form_mini')
        .val('')
        .removeClass('is-valid');
    $('#bancos_opcion').val('store');
}

function destroyBanco(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            let valor_x = $('#input_hidden_valor_x').val();
            ajaxRequest({ url: '_request/BancosRequest.php', data: { opcion: 'delete', id: id } }, function (data) {
                if (data.result) {
                    let table = $('#table_bancos').DataTable();
                    let item = $('#btn_eliminar_banco_' + id).closest('tr');
                    table
                        .row(item)
                        .remove()
                        .draw();

                    resetForm();
                    valor_x = valor_x - 1;
                    if (valor_x === 0){
                        reconstruirTabla();
                    }else {
                        $('#input_hidden_valor_x').val(valor_x);
                    }
                }
            });


        }

    });
}

function reconstruirTabla() {
    ajaxRequest({ url: '_request/BancosRequest.php', data: { opcion: 'index'}, html: 'si' }, function (data) {
        $('#dataContainerBancos').html(data.html);
        datatable('table_bancos');
    });
}


console.log('bancos..');