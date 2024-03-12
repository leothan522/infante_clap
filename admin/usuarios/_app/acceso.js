
function getUsuariosMunicipios() {
    ajaxRequest({url: '_request/AccesoRequest.php', data: {opcion: 'get_user'}}, function (data) {

        if (data.result) {
            let selectUsuarios = $('#usuarios_select_usuarios');
            let selectMunicipios = $('#usuarios_select_municipios');
            let municipios = data.municipios.length;
            selectMunicipios.empty();
            selectMunicipios.append('<option value="">Seleccione</option>');
            for (let i = 0; i < municipios; i++) {
                let id = data.municipios[i]['id'];
                let nombre = data.municipios[i]['nombre'];
                selectMunicipios.append('<option value="' + id + '">' + nombre + '</option>');
            }
            let usuarios = data.usuarios.length;
            selectUsuarios.empty();
            selectUsuarios.append('<option value="">Seleccione</option>');
            for (let i = 0; i < usuarios; i++) {
                let id = data.usuarios[i]['id'];
                let nombre = data.usuarios[i]['email'];
                selectUsuarios.append('<option value="' + id + '">' + nombre + '</option>');
            }
        }

    });
}

function getAccesosMunicipio() {
    ajaxRequest({url: '_request/AccesoRequest.php', data: { opcion: 'index' }, html: 'si'}, function (data) {
        $('#usuario_card_table').html(data.html);
        datatable('usuario_table_acceso');
        $('#btn_reset_acceso_municipio').click();
    });
}

$('#modal_acceso_form').submit(function (e) {
    e.preventDefault()
    let procesar = true;
    let usuario = $('#usuarios_select_usuarios');
    let municipios = $('#usuarios_select_municipios');

    if (usuario.val().length <= 0) {
        procesar = false;
        usuario.addClass('is-invalid');
        $('#error_usuarios_select_usuarios').text('El Usuario es obligatorio.');
    } else {
        usuario.removeClass('is-invalid');
        usuario.addClass('is-valid');
    }

    if (municipios.val().length <= 0) {
        procesar = false;
        municipios.addClass('is-invalid');
        $('#error_usuarios_select_municipios').text('Municipios es obligatorio.');
    } else {
        municipios.removeClass('is-invalid');
        municipios.addClass('is-valid');
    }

    if (procesar) {

        ajaxRequest({ url: '_request/AccesoRequest.php', data: $(this).serialize(), html: 'si' }, function (data) {
            getAccesosMunicipio();
        });

    }
});

function destroyAcceso(id) {
    MessageDelete.fire().then((result) => {
        let valor_x = $('#input_hidden_usuarios_valor_x').val();
        if (result.isConfirmed) {

            ajaxRequest({ url: '_request/AccesoRequest.php', data: { opcion: 'destroy', id: id } }, function (data) {

                if (data.result) {

                    let table = $('#usuario_table_acceso').DataTable();
                    let item = $('#btn_eliminar_acceso_' + id).closest('tr');
                    table
                        .row(item)
                        .remove()
                        .draw();

                    $('#paginate_leyenda_acceso').text(data.total);
                    valor_x = valor_x - 1;
                    if (valor_x === 0){
                        getAccesosMunicipio();
                    }else {
                        $('#input_hidden_usuarios_valor_x').val(valor_x);
                    }
                }

            });

        }
    });
}

function resetFormAcceso() {
    let usuario = $('#usuarios_select_usuarios');
    let municipios = $('#usuarios_select_municipios');
    usuario
        .removeClass('is-valid')
        .removeClass('is-invalid')
        .val("")
        .trigger('change');
    municipios
        .removeClass('is-valid')
        .removeClass('is-invalid')
        .val("")
        .trigger('change');
}


